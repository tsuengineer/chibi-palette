<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Avatar;
use App\Models\Favorite;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    public function show($userSlug)
    {
        $user = User::with('avatars', 'posts')
            ->withSum('posts', 'views')
            ->where('slug', $userSlug)
            ->first();

        if (!$user) {
            return response()->view('errors.404');
        }

        $posts = $user->posts()
            ->orderBy('created_at', 'desc')
            ->paginate(40);

        $favorite_count = Favorite::whereHas('post', function($query) use($user) {
            $query->where('user_id', $user->id);
        })->count();

        return view('profile.show', [
            'user' => $user,
            'posts' => $posts,
            'favoriteCount' => $favorite_count,
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user()->load('avatars'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $data = $request->validated();
        unset($data['avatar']);
        $request->user()->fill($data);

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        // アバターの登録
        if($request->file('avatar')) {
            // 現在のアバター情報
            $currentAvatar = Avatar::where('user_id', $request->user()->id)->first();

            $file = $request->file('avatar');
            $filename = Str::random(6) . '.webp';

            $image = Image::make($file);
            $image->fit(300, 300);

            // アバターが既に存在すれば更新、なければ新規作成
            $avatar = $request->user()->avatars ?? new Avatar(['user_id' => $request->user()->id]);
            $avatar->path = $filename; // 新しいアバターのパスを設定
            $avatar->save();

            // 保存先
            $directory = user_directory_path($request->user()->id);

            // 古いアバターを削除
            if ($currentAvatar) {
                Storage::disk('direct')->delete('images/avatar/' . $directory . '/' . $currentAvatar->path);
            }

            // storageディレクトリに保管
            Storage::disk('direct')->put('images/avatar/' . $directory . '/' . $filename, (string) $image->encode());
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
