<?php

namespace App\Http\Controllers\Admin;

use App\Events\ArticlePublished;
use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleController\storeRequest;
use App\Http\Requests\ArticleController\updateRequest;
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
    public function store(storeRequest $request)
    {
        $user_id = auth()->id();
        $validated_data = $request->validated();
        $article = Article::create([
            'title'       => $validated_data['title'],
            'body'        => $validated_data['body'],
            'user_id'     => $user_id,
        ]);

        if (!empty($validated_data['categories'])) {
            $article->categories()->attach($validated_data['categories']);
        }
        event(new ArticlePublished($article));

        return response()->json([
            'success' => true,
            'article' => $article
        ]);
    }
    public function update(updateRequest $request, Article $article)
    {
        $validated_data = $request->validated();
        $article->update([
            'title' => $validated_data['title'],
            'body'  => $validated_data['body'],
        ]);

        if (!empty($validated_data['categories'])) {
            $article->categories()->sync($validated_data['categories']);
        }
        return response()->json([
            'success' => true,
            'message' => 'Article updated successfully',
            'article' => $article
        ]);
    }
    public function destroy(Article $article)
    {
        $article->delete();
        return response()->json([
            'success' => true,
            'message' => 'Article deleted successfully',
        ]);
    }
}
