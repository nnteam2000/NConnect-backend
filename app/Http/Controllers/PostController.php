<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(['posts' => Post::with(['user', 'comments'])->latest()->simplePaginate(5)]);
    }

    public function show(Post $post)
    {
        return response()->json(['post' => $post->load(['user', 'comments'])]);
    }
}
