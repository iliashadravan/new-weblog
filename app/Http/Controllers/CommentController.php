<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentController\storeRequest;
use App\Models\Article;
use App\Models\Comment;

class CommentController extends Controller
{
    public function comment(storeRequest $request)
    {
        $userId = auth()->id();
        $commentableType = $request->commentable_type;
        $commentableId = $request->commentable_id;

        $comment = Comment::create([
            'body' => $request->body,
            'user_id' => $userId,
            'commentable_id' => $commentableId,
            'commentable_type' => $commentableType === 'comment' ? Comment::class : Article::class,
        ]);

        return response()->json([
            'message' => 'Comment or reply added successfully',
            'success' => true,
            'comment' => $comment,
        ]);
    }
}
