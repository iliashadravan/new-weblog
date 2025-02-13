<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Middleware\CheckSanctumAuth;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware([CheckSanctumAuth::class])->group(function () {
    Route::prefix('articles')->group(function () {
        Route::get('', [ArticleController::class, 'index']);
        Route::post('', [ArticleController::class, 'store']);
        Route::put('/{article}', [ArticleController::class, 'update']);
        Route::delete('{article}', [ArticleController::class, 'destroy']);
        Route::post('/likes/{article}', [ArticleController::class, 'like']);
        Route::post('/rate/{article}', [ArticleController::class, 'rate']);
        Route::post('/comments', [CommentController::class, 'comment']);
    });
});

