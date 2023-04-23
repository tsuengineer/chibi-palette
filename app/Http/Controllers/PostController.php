<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\AiModel;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    private $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function create()
    {
        $ai_models = AiModel::all();

        return view('posts.upload', [
            'aiModels' => $ai_models,
        ]);
    }

    public function show(string $ulid)
    {
        $post = Post::with('user', 'user.avatars', 'tags', 'aiModel')
            ->withCount('favorites')
            ->where('ulid', $ulid)
            ->first();

        if (!$post) {
            return response()->view('errors.404');
        }

        if (!$this->postService->isPostViewed($post->id)) {
            // 初回訪問時または訪問から24時間経過後は閲覧数を加算する。
            $this->postService->incrementPostViews($post);

            // アクセスログテーブルにIPアドレスとpostIDを記録する。
            $this->postService->recordAccessLog($post);
        }

        // 非公開設定(投稿者本人は閲覧可能)
        if (!$post->visibility_prompt && $post->user_id !== Auth::user()?->id) {
            $post->prompt = '';
            $post->negative_prompt = '';
        }

        // その他の投稿
        $otherPosts = Post::where('user_id', $post->user_id)
            ->where('ulid', '!=', $ulid)
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        return response()->view('posts.show', compact('post', 'otherPosts'));
    }

    public function edit(string $ulid)
    {
        $post = Post::with('user', 'user.avatars', 'tags')->where('ulid', $ulid)->first();

        if (!$post) {
            return response()->view('errors.404');
        }

        if ($post->user_id !== Auth::user()->id) {
            return response()->view('errors.403');
        }

        $ai_models = AiModel::all();

        return view('posts.edit', [
            'post' => $post,
            'aiModels' => $ai_models,
        ]);
    }

    public function upload(PostStoreRequest $request): RedirectResponse
    {
        // 投稿数が100件を超えている場合、エラーを返す
        if (Auth::user()->posts()->count() >= 100) {
            return redirect()->route('posts.upload');
        }

        $result = $this->postService->uploadPost($request);

        if ($result->isSuccess()) {
            Log::info('Success upload.', ['request' => $request]);
            return redirect()->action([UserController::class, 'index'])->with('success', 'イラストの投稿が成功しました。');
        } else {
            return back()->withErrors($result->getErrors())->withInput();
        }
    }

    public function update(PostUpdateRequest $request): RedirectResponse
    {
        $result = $this->postService->updatedPost($request);

        if ($result->isSuccess()) {
            return redirect()->action([UserController::class, 'index'])->with('success', 'イラスト情報の編集が成功しました。');
        } else {
            return back()->withErrors($result->getErrors())->withInput();
        }
    }

    public function delete(Request $request, string $ulid)
    {
        $deleteConfirm = $request->input('deleteConfirmText');
        if ($deleteConfirm !== '完全に削除') {
            return response()->view('errors.403');
        }

        $post = Post::where('ulid', $ulid)->first();

        if (!$post) {
            return response()->view('errors.204');
        }

        // 中間テーブルのレコードを削除
        $post->tags()->detach();

        // いいねテーブルのレコードを削除
        $post->favorites()->delete();

        // アクセスログテーブルのレコードを削除
        $post->accesslogs()->delete();

        // ランキングテーブルのレコードを削除
        $post->rankings()->delete();

        // 投稿を削除
        $post->delete();

        // ファイルを削除
        $directory = user_directory_path(Auth::user()->id);
        $filename = $post->ulid . '.webp';
        Storage::disk('direct')->delete('images/post/' . $directory . '/main/' . $filename);
        Storage::disk('direct')->delete('images/post/' . $directory . '/thumbnail/' . $filename);

        return redirect()->route('users.index')->with('success', 'イラストの削除が成功しました。');
    }
}
