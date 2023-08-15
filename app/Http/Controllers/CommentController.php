<?php

namespace App\Http\Controllers;

use App\Http\Requests\comments\StoreRequest;
use App\Http\Requests\comments\UpdateRequest;
use App\Models\Comment;
use Exception;
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

    public function store(StoreRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        if(isset($data['parent_id'])) {
            $parent = Comment::find($data['parent_id']);
            $parent->update(['children_count' => $parent->children_count + 1]);
        }

        Comment::create($data);

        return response()->json(['comment' => 'Comment created successfully']);
    }

    public function update(UpdateRequest $request, Comment $comment): JsonResponse
    {
        $comment->update($request->validated());

        return response()->json(['comment' => 'Comment updated successfully']);
    }
}
