<?php


use App\Http\Controllers\PostController;
use App\Http\Controllers\Api\NewsletterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Frontend - Posts
|--------------------------------------------------------------------------
*/

Route::get('/', [PostController::class, 'index'])->name('home');

Route::get('/post/{slug}', [PostController::class, 'show'])
    ->name('post.show');

/*
|--------------------------------------------------------------------------
| Newsletter
|--------------------------------------------------------------------------
*/

Route::prefix('newsletter')->group(function () {
    Route::get('/', [NewsletterController::class, 'form'])
        ->name('newsletter.form');

    Route::post('/subscribe', [NewsletterController::class, 'subscribe'])
        ->name('newsletter.subscribe');

    Route::get('/confirm/{token}', [NewsletterController::class, 'confirm'])
        ->name('newsletter.confirm');

    Route::get('/unsubscribe/{token}', [NewsletterController::class, 'unsubscribe'])
        ->name('newsletter.unsubscribe');
});


//teste send all
Route::get('/newsletter/test/send-all', [
    NewsletterController::class,
    'sendAllPostsTest'
]);

//etapa 2
Route::get('/admin/posts/create', [PostController::class, 'create']);
Route::post('/admin/posts', [PostController::class, 'store']);


// TESTE BREVO
Route::get('/newsletter/test/brevo', [
    NewsletterController::class,
    'brevoTest'
]);

Route::prefix('api')->group(function () {

    Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])
        ->name('api.newsletter.subscribe');

});


