<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;


class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with(['user', 'likes', 'rates', 'comments'])->get();

        return response()->json([
            'articles' => $articles,
            'success'  => true,
        ]);
    }

}
