<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\BlogCommentRequest;
use App\Http\Requests\v1\BlogDeleteCommentRequest;
use App\Http\Requests\v1\BlogFeedbackRequest;
use App\Http\Requests\v1\BlogFeedbackVoteRequest;
use App\Http\Requests\v1\BlogImageAnnotationRequest;
use App\Http\Requests\v1\CreateBlogRequest;
use App\Http\Requests\v1\ImagePredictionsRequest;
use App\Http\Requests\v1\UpdateBlogRequest;
use App\Http\Resources\v1\BlogCollection;
use App\Http\Resources\v1\BlogDetailsResource;
use App\Http\Resources\v1\UserResource;
use App\Models\Blog;
use App\Models\BlogComments;
use App\Models\BlogFeedback;
use App\Models\BlogImages;
use App\Models\BlogParticipate;
use App\Models\MLPredictions;
use App\Models\User;
use App\Models\UserAnnotations;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\alert;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $blog_ids = $user->blogParticipations->pluck('blog_id')->toArray();
        $blogs = Blog::whereIn('id', $blog_ids)
            ->orderBy('created_on', 'desc')
            ->paginate();
        return new BlogCollection($blogs);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateBlogRequest $request)
    {
        try {
            DB::beginTransaction();
            $blog = Blog::create($request->except('files'));
            //meeting data
            if ($request->has_meeting) {
                $meetingInfo = [];
                $meetingInfo['scheduled'] = $request->scheduled;
                $meetingInfo['link'] = $request->link;
                $meetingInfo['duration'] = $request->duration;
                $meeting = $blog->meeting()->create($meetingInfo);
            }
            //blog images
            $files = $request->file('files');
            if ($files) {
                foreach ($files as $file) {
                    $fileData = [];
                    $fileData['image_name'] = $file->getClientOriginalName();
                    $fileData['type'] = $file->getMimeType();
                    $fileData['image_binary'] = file_get_contents($file->getPathname());
                    $fileData['hash_key'] = hash('sha256', $fileData['image_binary']);
                    $blogImage = $blog->blogImages()->create($fileData);
                }
            }
            //participants
            $participants = $request->participants;
            if ($participants) {
                foreach ($participants as $username) {
                    $user = User::where('username', $username)->first();
                    //Skipping the owner as a participant!
                    if (Auth::user()->id == $user->id) {
                        continue;
                    }
                    BlogParticipate::create([
                        'blog_id' => $blog->id,
                        'user_id' => $user->id
                    ]);
                }
            }
            //Adding the owner as a participant!
            BlogParticipate::create([
                'blog_id' => $blog->id,
                'user_id' => Auth::user()->id,
                'status' => 1
            ]);
            DB::commit();
            return [
                'success' => 'blog created successfully!'
            ];
        } catch (e) {
            DB::rollBack();
            return [
                'error' => 'error while creating blog!'
            ];
        }
    }

    public function updateBlog($blogID, UpdateBlogRequest $request)
    {
        $blog = Blog::find($blogID);
        if (!$blog) {
            return [
                'error' => 'blog not found!'
            ];
        }
        $blog->update($request->except('cover_img'));
        //update cover image
        $blogCoverImg = $request->file('cover_image');
        if ($blogCoverImg) {
            $blog->cover_image = file_get_contents($blogCoverImg->getPathname());
            $blog->save();
        }
        //meeting (create/update)
        if ($request->has_meeting) {
            $meetingInfo = [];
            $meetingInfo['scheduled'] = $request->scheduled;
            $meetingInfo['link'] = $request->link;
            $meetingInfo['duration'] = $request->duration;
            if (!$blog->meeting()) {
                $meeting = $blog->meeting()->create($meetingInfo);
            } else {
                $blog->meeting()->update($meetingInfo);
            }
        }
        //blog images (add more images)
        $files = $request->file('files');
        if ($files) {
            $existingFileHashes = array_map(function ($file) {
                return $file['hash_key'];
            }, $blog->blogImages->toArray());
            foreach ($files as $file) {
                $fileData = [];
                $fileData['image_name'] = $file->getClientOriginalName();
                $fileData['type'] = $file->getMimeType();
                $fileData['image_binary'] = file_get_contents($file->getPathname());
                $fileData['hash_key'] = hash('sha256', $fileData['image_binary']);
                if (!in_array($fileData['hash_key'], $existingFileHashes)) {
                    $blogImage = $blog->blogImages()->create($fileData);
                }
            }
        }
        // update participants
        $participants = $request->participants;
        if ($participants) {
            $existingUsernames = array_map(function ($participant) {
                return User::find(($participant['user_id']))->username;
            }, $blog->blogParticipants->toArray());
            foreach ($participants as $username) {
                if (!in_array($username, $existingUsernames)) {
                    $user = User::where('username', $username)->first();
                    BlogParticipate::create([
                        'blog_id' => $blog->id,
                        'user_id' => $user->id
                    ]);
                }
            }
        }
        return [
            'success' => 'blog updated successfully!'
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $blog = Blog::find($id);
        if (!$blog) {
            return new BlogDetailsResource([]);
        }
        $participants = array_map(fn($p) => $p['user_id'], $blog->blogParticipants->toArray());
        if (!in_array(Auth::user()->id, $participants)) {
            return [
                'error' => 'blog access denied!'
            ];
        }
        return new BlogDetailsResource($blog);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        return [
            'error' => $request->method() . ' ' . 'method is not supported!'
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return ['delete method soon will be implemented!'];
    }

    public function deleteBlogImage($blogID, $imgID)
    {
        $blog = Blog::find($blogID);
        if (!$blog) {
            return new BlogDetailsResource([]);
        }
        if ($blog->user_id != Auth::user()->id) {
            return [
                'error' => 'access denied!'
            ];
        }
        $blogImage = BlogImages::find($imgID);
        if ($blogImage && $blogImage->blog_id === $blog->id) {
            $blogImage->delete();
            return [
                'success' => 'blog image deleted successfully'
            ];
        } else {
            return [
                'error' => 'image not found!!'
            ];
        }
    }

    public function deleteParticipant($blogID, $username)
    {
        $blog = Blog::find($blogID);
        if (!$blog) {
            return new BlogDetailsResource([]);
        }
        $user = User::where('username', $username)->first();
        if (!$user) {
            return [
                'error' => 'user not found!'
            ];
        }
        if ($blog->user_id != Auth::user()->id || Auth::user()->id == $user->id) {
            return [
                'error' => 'access denied!'
            ];
        }
        $participant = BlogParticipate::where([
            'blog_id' => $blog->id,
            'user_id' => $user->id
        ])->first();
        if ($participant) {
            $participant->delete();
            return [
                'success' => 'participant deleted successfully!'
            ];
        } else {
            return [
                'error' => 'participant not found!'
            ];
        }
    }

    public function ImageAnnotation($blogID, BlogImageAnnotationRequest $request)
    {
        $blog = Blog::find($blogID);
        if (!$blog) {
            return [
                'error' => 'blog does not exist!'
            ];
        }
        $participantsIDs = array_map(fn($p) => $p['user_id'], $blog->blogParticipants->toArray());
        if (!in_array(Auth::user()->id, $participantsIDs)) {
            return [
                'error' => 'access denied!'
            ];
        }
        if ($request->method() == 'GET') {
            return UserAnnotations::where([
                'user_id' => $request->user_id,
                'blog_id' => $blog->id,
                'image_id' => $request->image_id
            ])->first();
        } else
            if ($request->method() == 'POST') {

                $userAnnotation = UserAnnotations::where([
                    'user_id' => Auth::user()->id,
                    'blog_id' => $blog->id,
                    'image_id' => $request->image_id
                ])->first();

                if (!$userAnnotation) {
                    UserAnnotations::create([
                        'user_id' => Auth::user()->id,
                        'blog_id' => $blog->id,
                        'image_id' => $request->image_id,
                        'annotation' => $request->annotation
                    ]);
                    return [
                        'success' => 'annotation created successfully!'
                    ];
                } else {
                    $userAnnotation->update($request->except('image_id'));
                    return [
                        'success' => 'annotation updated successfully!'
                    ];
                }
            }
    }

    public function blogComment($blogID, BlogCommentRequest $request)
    {
        $blog = Blog::find($blogID);
        if (!$blog) {
            return [
                'error' => 'blog does not exist!'
            ];
        }
        if ($request->method() == 'GET') {
            $comments = [];
            foreach ($blog->blogComments->sortByDesc('datetime')->toArray() as $item) {
                $item['user'] = new UserResource(User::find($item['user_id']));
                $item['datetime'] = Carbon::parse($item['datetime'])->format('D m Y H:i');
                $comments[] = $item;
            }
            return $comments;
        } else
            if ($request->method() == 'POST') {
                $comment = BlogComments::find($request->comment_id);
                if (!$comment) {
                    $request->merge([
                        'blog_id' => $blog->id
                    ]);
                    $comment = BlogComments::create($request->all());
                    return [
                        'success' => 'comment created successfully!'
                    ];
                } else {
                    $comment->update($request->except('user_id', 'blog_id'));
                    return [
                        'success' => 'comment updated successfully!'
                    ];
                }
            }
    }

    public function deleteComment($blogID, BlogDeleteCommentRequest $request)
    {
        $blog = Blog::find($blogID);
        if (!$blog) {
            return [
                'error' => 'blog does not exist!'
            ];
        }
        $comment = BlogComments::find($request->comment_id);
        if ($comment) {
            if ($comment->user_id != Auth::user()->id || $comment->blog_id != $blog->id) {
                return [
                    'error' => 'access denied!'
                ];
            }
            $comment->delete();
            return [
                'success' => 'comment deleted successfully!'
            ];
        } else {
            return [
                'error' => 'comment not found!'
            ];
        }
    }

    public function feedback($blogID, BlogFeedbackRequest $request)
    {
        $blog = Blog::find($blogID);
        if (!$blog) {
            return [
                'error' => 'blog does not exist!'
            ];
        }
        $blog_feedback = $blog->blogFeedback;
        if ($request->method() === 'GET') {
            $data = $blog_feedback->toArray();
            $data['votes'] = $blog_feedback->feedbackData;
            return $data;
        } else
            if ($request->method() === 'POST') {
                if (!$blog_feedback) {
                    $blog_feedback = $blog->blogFeedback()->create(['labels' => json_encode($request->labels)]);
                    return [
                        'success' => 'blog feedback created successfully!'
                    ];
                } else {
                    $blog_feedback->update(['labels' => json_encode($request->labels)]);
                    return [
                        'success' => 'blog feedback updated successfully!'
                    ];
                }
            }
    }

    public function icd10AutoComplete(Request $request)
    {
        //providing auto-complete from around 95623 code
        $query = strip_tags($request->query('q'));
        $icd10_codes = App::make('icd10_codes');
        $filteredData = array_filter($icd10_codes, function ($item) use ($query) {
            return stripos($item['description'], $query);
        });
        return array_values($filteredData);
    }

    public function feedbackVote($blogID, BlogFeedbackVoteRequest $request)
    {
        $blog = Blog::find($blogID);
        if (!$blog) {
            return [
                'error' => 'blog does not exist!'
            ];
        }
        $feedback = $blog->blogFeedback;
        if ($request->method() == 'GET') {
            return $feedback->feedbackData ?? [];
        } else
            if ($request->method() == 'POST') {
                $feedback_data = $feedback->feedbackData()->where('voted_by', Auth::user()->id)->first();
                if (!$feedback_data) {
                    $feedback->feedbackData()->create($request->all());
                    return [
                        'success' => 'feedback vote created successfully!'
                    ];
                } else {
                    $feedback_data->update($request->all());
                    return [
                        'success' => 'feedback vote updated successfully!'
                    ];
                }
            }
    }

    public function saveImagePredictions($blogID, ImagePredictionsRequest $request)
    {
        $blog = Blog::find($blogID);
        if (!$blog) {
            return [
                'error' => 'blog does not exist!'
            ];
        }
        $img_predictions = MLPredictions::where(['blog_id' => $blog->id, 'image_id' => $request->image_id])->first();
        if (!$img_predictions) {
            $blog->MLPredictions()->create($request->all());
            return [
                'success' => 'image predictions created successfully!'
            ];
        } else {
            $img_predictions->update($request->all());
            return [
                'success' => 'image predictions updated successfully!'
            ];
        }
    }

}
