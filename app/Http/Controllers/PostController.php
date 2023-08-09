<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    public function index(): JsonResponse
    {
        $skip = request()->skip || 0;
        $posts = Post::latest()->skip($skip)->take(10)->get();
        $is_more = Post::count() - ($skip + 10);

        return response()->json(['posts' =>$posts->load('user'), 'skip' => $skip +10, 'is_more' => $is_more > 0]);
    }

}
