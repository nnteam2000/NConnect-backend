<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(['posts' => Post::with([
        'user' => fn ($query) => $query->select(['id', 'name', 'image']),
        'comments.user' => fn ($query) => $query->select(['id', 'name', 'image']),
        'comments'
        ])->latest()->simplePaginate(5)]);
    }

    public function show(Post $post)
    {
        return response()->json(['post' => $post->
        load(['user' => fn ($query) => $query->select(['id', 'name', 'image']), 'comments'])
        ]);
    }
}
