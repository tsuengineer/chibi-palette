<?php

namespace App\Services;

use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\AccessLog;
use App\Models\Post;
use App\Models\Tag;
use App\Utils\ResponseUtil;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Response;

class PostService
{
    public function incrementPostViews(Post $post): Post
    {
        $post->views++;
        $post->save();

        return $post;
    }

    public function isPostViewed($postId): bool
    {
        $ipAddress = request()->ip();
        $accessLog = AccessLog::where('post_id', $postId)
            ->where('ip_address', $ipAddress)
            ->where('created_at', '>=', Carbon::now()->subDay())
            ->first();

        return $accessLog !== null;
    }

    public function recordAccessLog($post) {
        $accessLog = new AccessLog();
        $accessLog->ip_address = request()->ip();
        $accessLog->post_id = $post->id;
        $accessLog->save();
    }

    public function uploadPost(PostStoreRequest $request): Response | ResponseUtil
    {
        // 入力内容のバリデーション
        if (!$request->validated()) {
            Log::error('Upload Post validation error.', ['errors' => $request->errors()]);
            return ResponseUtil::createWithErrors($request->errors());
        }

        // postsテーブル更新と画像の登録
        $file = $request->file('image');

        $data = $request->validated();
        unset($data['image']);
        $post = new Post($data);
        $post->title = $post->title ?? '無題';
        $post->user()->associate($request->user());
        $post->ulid = Str::ulid();

        $directory = user_directory_path($request->user()->id);
        $filename = $post->ulid . '.webp';

        // 画像のアップロードとリサイズ
        $image = Image::make($file);

        // メイン画像リサイズ
        if ($image->width() > 1200 || $image->height() > 1200) {
            // 幅と高さを比較して、長い方を1200pxにリサイズ
            $this->resizeImage($image, 1200, 1200);
        } else if ($image->width() > 1000 || $image->height() > 1000) {
            // 幅と高さを比較して、長い方を1000pxにリサイズ
            $this->resizeImage($image, 1000, 1000);
        } else if ($image->width() > 800 || $image->height() > 800) {
            // 幅と高さを比較して、長い方を800pxにリサイズ
            $this->resizeImage($image, 800, 800);
        }

        if (!Storage::disk('direct')->put('images/post/' . $directory . '/main/' . $filename, (string) $image->encode('webp'))) {
            Log::error('Failed to save main image.', ['image' => $image]);
            return ResponseUtil::createWithErrors(['image' => 'Failed to upload file.']);
        }

        // サムネイル画像
        $image->fit(300, 300);
        if (!Storage::disk('direct')->put('images/post/' . $directory . '/thumbnail/' . $filename, (string) $image->encode('webp'))) {
            Log::error('Failed to save thumbnail.', ['image' => $image]);
            return ResponseUtil::createWithErrors(['image' => 'Failed to upload file.']);
        }

        $post->save();

        // tagsテーブルと中間テーブルの登録・更新
        $tags = $this->getTagsByName(array_filter($request->tags));
        try {
            $this->saveTags($post, $tags);
        } catch (\Exception $e) {
            // 失敗した場合はpostsテーブルと画像の登録を巻き戻す
            Storage::disk('direct')->delete('images/post/' . $directory . '/' . $filename);
            $post->delete();
            Log::error('Failed to save tags.', ['exception' => $e]);
            return ResponseUtil::createWithErrors(['tags' => 'Failed to save tags.']);
        }

        return ResponseUtil::createSuccess();
    }

    public function updatedPost(PostUpdateRequest $request)
    {
        // 入力内容のバリデーション
        if (!$request->validated()) {
            return ResponseUtil::createWithErrors($request->errors());
        }

        $post = Post::where('ulid', $request->ulid)->firstOrFail();

        if ($post->user_id !== Auth::user()->id) {
            return response()->view('errors.403');
        }

        // postsテーブルの更新
        $post->fill($request->only([
            'title',
            'prompt',
            'negative_prompt',
            'visibility_prompt',
            'steps',
            'scale',
            'seed',
            'sampler',
            'strength',
            'noise',
            'ai_model_id',
            'description',
            'tweet',
            ]));
        $post->save();

        // tagsテーブルの更新
        $newTags = $this->getTagsByName(array_filter($request->tags));
        $post->tags()->sync($newTags->pluck('id')->toArray());

        // 中間テーブルに存在しないtagを削除
        $tags = Tag::has('posts')->pluck('id');
        $unusedTags = Tag::whereNotIn('id', $tags)->get(); // 中間テーブルに存在しないタグを取得する
        $unusedTags->each->delete();

        return ResponseUtil::updateSuccess();
    }

    private function getTagsByName(array $tagNames): Collection
    {
        return collect($tagNames)->map(function ($tagName) {
            return Tag::firstOrCreate(['name' => $tagName]);
        });
    }

    private function saveTags(Post $post, Collection $tags): void
    {
        $tagsIds = $tags->pluck('id')->toArray();
        $post->tags()->attach($tagsIds);
    }

    private function resizeImage($image, $width, $height) {
        if ($image->width() > $image->height()) {
            $image->resize($width, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        } else {
            $image->resize(null, $height, function ($constraint) {
                $constraint->aspectRatio();
            });
        }
    }
}
