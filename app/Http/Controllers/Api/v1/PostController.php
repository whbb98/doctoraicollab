<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\CreatePostRequest;
use App\Http\Requests\v1\PostCommentRequest;
use App\Http\Requests\v1\PostInteractionRequest;
use App\Http\Requests\v1\UpdatePostRequest;
use App\Http\Resources\v1\PostCollection;
use App\Http\Resources\v1\PostResource;
use App\Models\Post;
use App\Models\PostComments;
use App\Models\PostInteractions;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new PostCollection(
            Auth::user()
                ->posts()
                ->orderBy('datetime', 'desc')
                ->paginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePostRequest $request)
    {
        $post = Post::create($request->except('files'));
        $files = $request->file('files');
        if ($files) {
            foreach ($files as $file) {
                $fileData = [];
                $fileData['file_name'] = $file->getClientOriginalName();
                $fileData['file_data'] = file_get_contents($file->getPathname());
                $fileData['file_extension'] = $file->extension();
                $postData = $post->postData()->create($fileData);
            }
        }
        return [
            'success' => 'post inserted successfully!'
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = Auth::user();
        $post = Post::find($id);
        if (!$post) {
            return new PostResource([]);
        }
        if (!$post->visibility && $user->id != $post->user_id) {
            return [
                'error' => 'post visibility is hidden by the author!'
            ];
        }
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        return [
            'error' => $request->method() . ' method is not supported!'
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $post = Post::find($id);
        if ($post && $post->user_id != $user->id) {
            return [
                'error' => 'permission denied!'
            ];
        }
        if (!$post) {
            return [
                'error' => 'post not found!'
            ];
        }
        return $post->delete() ? [
            'success' => 'post deleted successfully!'
        ] : [
            'error' => 'error while deleting post!'
        ];
    }

    public function updatePost($postID, UpdatePostRequest $request)
    {
        $post = Post::find($postID);
        if (!$post) {
            return [
                'error' => 'post not found!'
            ];
        }
        $post->update($request->except('user_id', 'post_id'));
        $files = $request->file('files');
        if ($files) {
            $post->postData()->delete();
            foreach ($files as $file) {
                $fileData = [];
                $fileData['file_name'] = $file->getClientOriginalName();
                $fileData['file_data'] = file_get_contents($file->getPathname());
                $fileData['file_extension'] = $file->extension();
                $postData = $post->postData()->create($fileData);
            }
        }
        return [
            'success' => 'post updated successfully!'
        ];
    }

    public function postInteraction($postID, PostInteractionRequest $request)
    {
        $post = Post::find($postID);
        if (!$post) {
            return [
                'error' => 'post not found!'
            ];
        }
        $user = Auth::user();
        if (isset($request->is_liked) || isset($request->is_shared)) {
            $postInteraction = PostInteractions::where([
                'user_id' => $user->id,
                'post_id' => $post->id
            ])->first();
            if (!$postInteraction) {
                $postInteraction = $post->PostInteractions()->create($request->all());
                return [
                    'success' => 'post interaction created successfully!'
                ];
            } else {
                $postInteraction->update($request->except('user_id', 'post_id'));
                return [
                    'success' => 'post interaction updated successfully!'
                ];
            }
        }
    }

    public function postComment($postID, PostCommentRequest $request)
    {
        $post = Post::find($postID);
        if (!$post) {
            return [
                'error' => 'post not found!'
            ];
        }
        $user = Auth::user();
        $postComment = $request->comment_id ? $post->PostComments()->find($request->comment_id) : null;
        if (!$postComment) {
            $postComment = $post->postComments()->create($request->all());
            return [
                'success' => 'post comment created successfully!'
            ];
        } else {
            if ($user->id == $postComment->user_id) {
                $postComment->update($request->except('user_id', 'post_id'));
                return [
                    'success' => 'post comment updated successfully!'
                ];
            }
        }
    }
}
