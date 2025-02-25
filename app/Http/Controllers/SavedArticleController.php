<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;

class SavedArticleController extends Controller
{
    public function toggleSave(Article $article)
    {
        $user = Auth::user();
        $saved = $user->savedArticles()->toggle($article->id);

        $message = count($saved['attached'])
            ? 'Article saved.'
            : 'The article was removed from the save list.';

        return response()->json(['message' => $message]);
    }

    public function getSavedArticles()
    {
        $savedArticles = Auth::user()->savedArticles()->get();
        return response()->json($savedArticles);
    }
}
