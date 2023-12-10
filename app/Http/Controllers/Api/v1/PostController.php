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

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new PostCollection(Post::paginate());
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
        $post = Post::find($id);
        if (!$post) {
            return new PostResource([]);
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
        $post = Post::find($id);
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
        $user = User::find($request->user_id);
        if (!$user) {
            return [
                'error' => 'user not found!'
            ];
        }
        if (isset($request->is_liked) || isset($request->is_shared)) {
            $postInteraction = PostInteractions::where([
                'user_id' => $user->id,
                'post_id' => $post->id
            ])->first();

            if (!$postInteraction) {
                $request->merge([
                    'post_id' => $post->id
                ]);
                $postInteraction = PostInteractions::create($request->all());
            } else {
                $postInteraction->update($request->except('user_id', 'post_id'));
            }
            return [
                'success' => 'post interaction inserted successfully!'
            ];
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
        $user = User::find($request->user_id);
        if (!$user) {
            return [
                'error' => 'user not found!'
            ];
        }
        $postComment = $request->comment_id ? PostComments::find($request->comment_id) : null;

        if (!$postComment) {
            $request->merge([
                'post_id' => $post->id
            ]);
            $postComment = PostComments::create($request->all());
        } else {
            if ($user->id === $postComment->user_id) {
                $postComment->update($request->except('user_id', 'post_id'));
            } else {
                return [
                    'error' => 'permission denied!!'
                ];
            }
        }
        return [
            'success' => 'post comment inserted successfully!'
        ];
    }
}
