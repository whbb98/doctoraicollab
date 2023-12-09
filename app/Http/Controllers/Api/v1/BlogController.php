<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\CreateBlogRequest;
use App\Http\Resources\v1\BlogCollection;
use App\Http\Resources\v1\BlogResource;
use App\Http\Resources\v1\UserResource;
use App\Models\Blog;
use App\Models\BlogImages;
use App\Models\BlogParticipate;
use App\Models\Meetings;
use App\Models\User;
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
                $fileData['type'] = $file->extension();
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

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $blog = Blog::find($id);
        if (!$blog) {
            return new BlogResource([]);
        }
        return new BlogResource($blog);
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
}
