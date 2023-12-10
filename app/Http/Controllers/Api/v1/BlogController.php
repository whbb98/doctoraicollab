<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\BlogImageAnnotationRequest;
use App\Http\Requests\v1\CreateBlogRequest;
use App\Http\Requests\v1\UpdateBlogRequest;
use App\Http\Resources\v1\BlogCollection;
use App\Http\Resources\v1\BlogDetailsResource;
use App\Models\Blog;
use App\Models\BlogImages;
use App\Models\BlogParticipate;
use App\Models\User;
use App\Models\UserAnnotations;
use Illuminate\Http\Request;

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
}
