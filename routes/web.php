<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminPostController;
use App\Http\Controllers\Admin\AdminTagController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\Main\IndexController as AdminMainIndexController;
use App\Http\Controllers\Category\IndexController as CategoryIndexController;
use App\Http\Controllers\Category\Post\IndexController as CategoryPostIndexController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\Personal\Comment\DeleteController as PersonalCommentDeleteController;
use App\Http\Controllers\Personal\Comment\EditController as PersonalCommentEditController;
use App\Http\Controllers\Personal\Comment\IndexController as PersonalCommentIndexController;
use App\Http\Controllers\Personal\Comment\UpdateController as PersonalCommentUpdateController;
use App\Http\Controllers\Personal\Liked\DeleteController as PersonalLikedDeleteController;
use App\Http\Controllers\Personal\Liked\IndexController as PersonalLikedIndexController;
use App\Http\Controllers\Personal\Main\IndexController as PersonalMainIndexController;
use App\Http\Controllers\PlaceholderController;
use App\Http\Controllers\Post\Comment\StoreController as PostCommentStoreController;
use App\Http\Controllers\Post\Like\StoreController as PostLikeStoreController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [PostController::class, 'showHomepage'])->name('main.index');

// Placeholder image generation
Route::get('/placeholder/{width}/{height}', [PlaceholderController::class, 'generate'])
    ->where(['width' => '[0-9]+', 'height' => '[0-9]+'])
    ->name('placeholder.generate');

Auth::routes(['verify' => false]);

Route::prefix('contacts')->group(function () {
    Route::get('/', [ContactsController::class, 'showContacts'])
        ->name('contact.index');
});

Route::prefix('about')->group(function () {
    Route::get('/', [AboutController::class, 'showAbout'])
        ->name('about.index');
});

Route::prefix('category')->group(function () {
    Route::get('/', CategoryIndexController::class)->name('category.index');
    Route::prefix('{category}/posts')->group(function () {
        Route::get('/', CategoryPostIndexController::class)->name('category.post.index');
    });
});

Route::prefix('post')->group(function () {
    Route::get('/{post}', [PostController::class, 'show'])->name('post.show');

    Route::prefix('{post}/comments')->group(function () {
        Route::post('/', PostCommentStoreController::class)->name('post.comments.store');
    });
    Route::prefix('{post}/likes')->group(function () {
        Route::post('/', PostLikeStoreController::class)->name('post.likes.store');
    });
});

Route::prefix('personal')->middleware(['auth'])->group(function () {
    Route::get('/', PersonalMainIndexController::class)->name('personal.main.index');


    Route::prefix('liked')->group(function () {
        Route::get('/', PersonalLikedIndexController::class)->name('personal.liked.index');
        Route::delete('/{post}', PersonalLikedDeleteController::class)->name('personal.liked.delete');
    });
    Route::prefix('comment')->group(function () {
        Route::get('/', PersonalCommentIndexController::class)->name('personal.comment.index');
        Route::delete('/{comment}', PersonalCommentDeleteController::class)->name('personal.comment.delete');
        Route::patch('/{comment}', PersonalCommentUpdateController::class)->name('personal.comment.update');
        Route::get('/{comment}', PersonalCommentEditController::class)->name('personal.comment.edit');
    });
});

Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::prefix('main')->group(function () {
        Route::get('/', AdminMainIndexController::class)->name('main.index');
    });
    Route::resource('category', AdminCategoryController::class);
    Route::resource('tag', AdminTagController::class);
    Route::resource('post', AdminPostController::class);
    Route::resource('user', AdminUserController::class);
});
