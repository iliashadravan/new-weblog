<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleController\storeRequest;
use App\Http\Requests\ArticleController\updateRequest;
use App\Http\Requests\RateController\rateRequest;
use App\Models\Article;
use App\Models\Notification;
use App\Models\User;
use App\Models\Category;
use App\Service\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Events\ArticlePublished;


class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::with('user:id,firstname,lastname,image')
            ->withCount(['likes', 'rates']);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($query) use ($search) {
                $query->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('body', 'LIKE', "%{$search}%");
            });
        }

        $articles = $query->get();

        return response()->json([
            'success'  => true,
            'articles' => $articles
        ]);
    }


    public function store(storeRequest $request)
    {
        $validated_data = $request->validated();

        $article = Article::create([
            'title'   => $validated_data['title'],
            'body'    => $validated_data['body'],
            'user_id' => auth()->id(),
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
        if ($article->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
            ], 403);
        }

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
            'article' => $article
        ]);
    }

    public function destroy(Article $article)
    {
        if ($article->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
            ], 403);
        }

        $article->delete();

        return response()->json([
            'success' => true,
            'article' => $article,
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

    public function rate(RateRequest $request, Article $article)
    {
        $validated_data = $request->validated();
        $userId = auth()->id();
        $existing_rating = $article->rates()->where('user_id', $userId)->first();

        if ($existing_rating) {
            $article->rates()->updateExistingPivot($userId, ['rate' => $validated_data['rate']]);
        } else {
            $article->rates()->attach($userId, ['rate' => $validated_data['rate']]);
        }

        return response()->json([
            'success' => true,
        ]);
    }
}
