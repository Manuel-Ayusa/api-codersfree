<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PostController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(middleware: 'auth:api', except: ['index', 'show']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::include()
                        ->filter()
                        ->sort()
                        ->getOrPaginate();

        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:250',
            'slug' => 'required|max:250|unique:posts',
            'stract' => 'required',
            'body' => 'required',
            'category_id' => 'required|exists:categories,id'
        ]);

        $user = auth()->user()->id;
        
        $data['user_id'] = $user;

        $post = Post::create($data);

        return PostResource::make($post);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $post = Post::include()->findOrFail($id);

        return PostResource::make($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'name' => 'required|max:250',
            'slug' => 'required|max:250|unique:posts,slug,' . $post->id,
            'stract' => 'required',
            'body' => 'required',
            'category_id' => 'required|exist:categories,id',
            'user_id' => 'required|exist:user,id'
        ]);

        $post->update($request->all());

        return PostResource::make($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return PostResource::make($post);
    }
}
