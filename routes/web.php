<?php

use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SearchResultController;
use App\Http\Controllers\TopController;
use App\Http\Controllers\UserController;
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

Route::get('/', [TopController::class, 'index'])->name('top.index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/posts/upload', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts/upload', [PostController::class, 'upload'])->name('posts.upload');
    Route::get('/posts/{ulid}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{ulid}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{ulid}', [PostController::class, 'delete'])->name('posts.delete');

    Route::get('/dashboard', [UserController::class, 'index'])->name('users.index');
});

Route::get('/posts/{ulid}', [PostController::class, 'show'])->name('posts.show');
Route::get('/users/{userSlug}', [ProfileController::class, 'show'])->name('profile.show');

Route::get('/about', function() {
    return view('static_pages.about');
});
Route::get('/terms', function() {
    return view('static_pages.terms');
});
Route::get('/model', function() {
    return view('static_pages.model');
});
Route::get('/license', function() {
    return view('static_pages.license');
});

Route::get('/search', [SearchController::class, 'index'])->name('search.index');
Route::post('/search', [SearchController::class, 'search'])->name('search.search');
Route::get('/search/tag/{tag}', [SearchController::class, 'filterByTag'])->name('filter_by_tag');

Route::get('/ranking', [RankingController::class, 'index'])->name('ranking.index');

Route::post('/favorites', [FavoriteController::class, 'store'])->name('favorite.store');
Route::delete('/favorites/{id}', [FavoriteController::class, 'destroy'])->name('favorite.destroy');

require __DIR__.'/auth.php';
