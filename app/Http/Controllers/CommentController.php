<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
    public function index(): JsonResponse
    {
        $skip = request('skip') ?: 0;
        $comments = Comment::when(request('parent_id') != null, fn ($q) => $q->where('parent_id', request('parent_id')))->
        when(request('post_id') != null, fn ($q) => $q->where('post_id', request('post_id')))->
        with('user:id,name,image');
        $has_more_pages = $comments->count() > $skip + 5;
        $comments = $comments->latest()->skip($skip)->take(5)->get();

        return response()->json(['comments' => $comments, 'has_more_pages' => $has_more_pages]);
    }
}
