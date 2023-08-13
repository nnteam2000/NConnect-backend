<?php

namespace App\Http\Controllers;

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

    public function show(Post $post)
    {
        return response()->json(['post' => $post->load('user:id,name,image')]);
    }
}
