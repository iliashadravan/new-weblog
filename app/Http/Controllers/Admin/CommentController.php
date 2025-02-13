<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Models\Article;
use App\Models\Comment;

class CommentController extends Controller
{
    public function index(Article $article)
    {
        $comments = Comment::where('commentable_id', $article->id)->with('replies')->get();

        return response()->json([
            'success' => true,
            'article' => $article,
            'comments' => $comments
        ]);
    }
    public function updateCommentsVisibility(Request $request)
    {
        $commentIds = (array) $request->input('comment_ids', []);
        $isVisible = $request->input('is_visible');

        if (!is_array($commentIds)) {
            $commentIds = [$commentIds];
        }

        if (empty($commentIds)) {
            return response()->json([
                'success' => false,
                'message' => 'No comments selected for update.'
            ], 400);
        }

        Comment::whereIn('id', $commentIds)->update(['is_visible' => $isVisible]);

        return response()->json([
            'success' => true,
            'message' => 'Comment(s) visibility updated successfully!'
        ]);
    }
}
