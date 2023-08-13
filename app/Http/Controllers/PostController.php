<?php

namespace App\Http\Controllers;

use App\Http\Requests\posts\StoreRequest;
use App\Http\Requests\posts\UpdateRequest;
use App\Models\Post;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            [
                'posts' => Post::with('user:id,name,image')->latest()->skip(request('skip') ?: 0)->take(5)->get(),
                'has_more_pages' => Post::count() > request('skip') + 5,
            ]
        );
    }

    public function show(Post $post): JsonResponse
    {
        return response()->json(['post' => $post->load('user:id,name,image')]);
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $image = $request->file('image') ? env('APP_URL') . '/storage/' . $request->file('image')->store('posts') : null;
        Post::create([...$request->validated(), 'image' => $image]);
        return response()->json(['comment' => 'Post created successfully']);
    }

    public function update(UpdateRequest $request, Post $post): JsonResponse
    {
        $data = $request->validated();
        $data['image'] = $request->file('image') ? env('APP_URL') . '/storage/' .  $request->file('image')->store('posts') : null;

        if($data['image'] == null && $data['content'] == null) {
            return response()->json(['comment' => 'Nothing to update'], 422);
        }

        $post->update($data);
        return response()->json(['comment' => 'Post updated successfully']);
    }
}
