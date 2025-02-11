<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleController\storeRequest;
use App\Models\Article;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;



class ArticleController extends Controller
{
    public function index()
    {
        $user_id = auth()->id();
        $user = User::find($user_id);

        $articles = $user->articles;

        return response()->json([
            'success' => true,
            'articles' => $articles
        ]);
    }
    public function store(storeRequest $request)
    {
        $validated_data = $request->validated();

        $article = Article::create([
            'title'   => $validated_data['title'],
            'body'    => $validated_data['body'],
            'user_id' => Auth::id(),
        ]);

        if (!empty($validated_data['categories'])) {
            $article->categories()->attach($validated_data['categories']);
        }

        return response()->json([
            'success' => true,
            'article' => $article
        ]);
    }
    public function update(storeRequest $request, Article $article)
    {
        $validated_data = $request->validated();

        $article->update([
            'title'   => $validated_data['title'],
            'body'    => $validated_data['body'],
        ]);

        if (!empty($validated_data['categories'])) {
            $article->categories()->sync($validated_data['categories']);
        }

        return response()->json([
            'success' => true,
            'article' => $article
        ]);
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return response()->json([
            'success' => true,
            'article' => $article,
            'message' => 'Article deleted successfully'
        ]);
    }
    public function like(Article $article)
    {
        $userId = auth()->id();
        $liked = !$article->likes()->where('user_id', $userId)->exists();

        $article->likes()->toggle($userId);  //check to know is like true ,false it

        return response()->json([
            'success' => true,
            'liked' => $liked,
        ]);
    }

}
