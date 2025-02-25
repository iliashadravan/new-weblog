<?php

use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\TicketAdminController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SavedArticleController;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\TicketController ;
use App\Http\Middleware\CheckIsAdmin;
use App\Http\Middleware\CheckSanctumAuth;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/send-sms', [SmsController::class, 'sendSms']);
    Route::post('/update-profile', [AuthController::class, 'updateProfile']);
    Route::post('/reset-password', [AuthController::class, 'forgotPassword']);
    Route::post('/update-user/{user}', [AdminUserController::class, 'updateUserInfo'])->middleware(CheckIsAdmin::class);
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
        Route::post('/notifications', [NotificationController::class, 'notification']);
        Route::post('/saved/{article}', [SavedArticleController::class, 'toggleSave']);
        Route::get('/user/saved-articles', [SavedArticleController::class, 'getSavedArticles']);
    });

    Route::prefix('tickets')->group(function () {
        Route::get('', [TicketController::class, 'index']);
        Route::post('', [TicketController::class, 'store']);
        Route::post('/message/{ticket}', [TicketController::class, 'sendMessage']);
    });

    Route::prefix('admin')->middleware([CheckIsAdmin::class])->group(function () {
        Route::prefix('/articles')->group(function () {
            Route::get('', [AdminArticleController::class, 'index']);
            Route::post('', [AdminArticleController::class, 'store']);
            Route::put('/{article}', [AdminArticleController::class, 'update']);
            Route::delete('{article}', [AdminArticleController::class, 'destroy']);
        });
        Route::prefix('/comments')->group(function () {
            Route::get('/{article}', [AdminCommentController::class, 'index']);
            Route::patch('/update-visibility', [AdminCommentController::class, 'updateCommentsVisibility']);
        });
        Route::prefix('tickets')->group(function () {
            Route::get('', [TicketAdminController::class, 'index']);
            Route::post('/message/{ticket}', [TicketAdminController::class, 'sendMessage']);
            Route::patch('/status/{ticket}', [TicketAdminController::class, 'updateStatus']);
        });
    });
});

