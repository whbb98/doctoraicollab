<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\BlogCommentRequest;
use App\Http\Requests\v1\BlogDeleteCommentRequest;
use App\Http\Requests\v1\BlogFeedbackRequest;
use App\Http\Requests\v1\BlogFeedbackVoteRequest;
use App\Http\Requests\v1\BlogImageAnnotationRequest;
use App\Http\Requests\v1\CreateBlogRequest;
use App\Http\Requests\v1\UpdateBlogRequest;
use App\Http\Resources\v1\BlogCollection;
use App\Http\Resources\v1\BlogDetailsResource;
use App\Models\Blog;
use App\Models\BlogComments;
use App\Models\BlogFeedback;
use App\Models\BlogImages;
use App\Models\BlogParticipate;
use App\Models\User;
use App\Models\UserAnnotations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use function Laravel\Prompts\alert;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new BlogCollection(Blog::paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateBlogRequest $request)
    {
        $blog = Blog::create($request->except('cover_image'));
        $blogCoverImg = $request->file('cover_image');
        if ($blogCoverImg) {
            $blog->cover_image = file_get_contents($blogCoverImg->getPathname());
            $blog->save();
        }
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
                BlogParticipate::create([
                    'blog_id' => $blog->id,
                    'user_id' => $user->id
                ]);
            }
        }
        return [
            'success' => 'blog inserted successfully!'
        ];
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

//        if ($blog->user_id != $user->id) {
//            return [
//                'error' => 'access denied!'
//            ];
//        }
        $blogImage = BlogImages::find($imgID);
        if ($blogImage && $blogImage->blog_id === $blog->id) {
            $blogImage->delete();
            return [
                'success' => 'blog image deleted successfully'
            ];
        } else {
            return [
                'error' => 'Not Found!!'
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
        if ($blog->user_id != $user->id) {
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
        $user = User::find($request->user_id);
        if (!$user) {
            return [
                'error' => 'user does not exist!'
            ];
        }
        $participantsIDs = array_map(fn($p) => $p['user_id'], $blog->blogParticipants->toArray());
        if (!in_array($user->id, $participantsIDs)) {
            return [
                'error' => 'user does not have permission to participate!'
            ];
        }
        $blogImagesIDs = array_map(fn($obj) => $obj['id'], $blog->blogImages->toArray());
        if (!in_array($request->image_id, $blogImagesIDs)) {
            return [
                'error' => 'no image found for annotation in this blog!'
            ];
        }
        $userAnnotation = UserAnnotations::where([
            'user_id' => $user->id,
            'blog_id' => $blog->id,
            'image_id' => $request->image_id
        ])->first();

        if (!$userAnnotation) {
            UserAnnotations::create([
                'user_id' => $user->id,
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

    public function blogComment($blogID, BlogCommentRequest $request)
    {
        $blog = Blog::find($blogID);
        if (!$blog) {
            return [
                'error' => 'blog does not exist!'
            ];
        }
        $user = User::find($request->user_id);
        if (!$user) {
            return [
                'error' => 'user does not exist!'
            ];
        }
        $participantsIDs = array_map(fn($p) => $p['user_id'], $blog->blogParticipants->toArray());
        if (!in_array($user->id, $participantsIDs)) {
            return [
                'error' => 'user does not have permission to participate!'
            ];
        }
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

    public function deleteComment($blogID, BlogDeleteCommentRequest $request)
    {
        $blog = Blog::find($blogID);
        if (!$blog) {
            return [
                'error' => 'blog does not exist!'
            ];
        }
        $user = User::find($request->user_id);
        if (!$user) {
            return [
                'error' => 'user does not exist!'
            ];
        }
        $participantsIDs = array_map(fn($p) => $p['user_id'], $blog->blogParticipants->toArray());
        if (!in_array($user->id, $participantsIDs)) {
            return [
                'error' => 'user does not have permission to participate!'
            ];
        }
        $comment = BlogComments::find($request->comment_id);
        if ($comment) {
            if ($comment->user_id != $user->id) {
                return [
                    'error' => 'Not authorized to delete!'
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
        $user = User::find($request->user_id);
        if (!$user) {
            return [
                'error' => 'user does not exist!'
            ];
        }
        if ($blog->user_id != $user->id) {
            return [
                'error' => 'access denied!'
            ];
        }
        $blog_feedback = $blog->blogFeedback;
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
        $user = User::find($request->voted_by);
        if (!$user) {
            return [
                'error' => 'user does not exist!'
            ];
        }
        $participantsIDs = array_map(fn($p) => $p['user_id'], $blog->blogParticipants->toArray());
        if (!in_array($user->id, $participantsIDs)) {
            return [
                'error' => 'user does not have permission to participate!'
            ];
        }
        $feedback = Blog::find($request->route('blogID'))->blogFeedback;
        $feedback_data = $feedback->feedbackData()->where('voted_by', $user->id)->first();
        if (!$feedback_data) {
            $feedback->feedbackData()->create($request->all());
            return [
                'success' => 'feedback voted created successfully!'
            ];
        } else {
            $feedback_data->update($request->all());
            return [
                'success' => 'feedback voted updated successfully!'
            ];
        }
    }

}
