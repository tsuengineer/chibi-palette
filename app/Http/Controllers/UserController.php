<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $user = User::with('avatars', 'posts')
            ->withSum('posts', 'views')
            ->where('id', Auth::user()->id)
            ->first();

        $favorite_post_ids = $user->favorites()->pluck('post_id');

        $posts = $user->posts()
            ->orderBy('created_at', 'desc')
            ->paginate(40, ['*'], 'page');

        $liked_posts = Post::whereIn('id', $favorite_post_ids)
            ->with('favorites')
            ->orderByRaw("FIELD(id, " . $favorite_post_ids->reverse()->implode(',') . ")")
            ->paginate(40, ['*'], 'likedPage');

        $favorite_count = Favorite::whereHas('post', function($query) use($user) {
            $query->where('user_id', $user->id);
        })->count();

        $url = $request->fullUrl();

        if (str_contains($url, 'likedPage')) {
            $tab = 2;
        } else {
            $tab = 1;
        }

        return view('users.index', [
            'user' => $user,
            'posts' => $posts,
            'likedPosts' => $liked_posts,
            'tab' => $tab,
            'favoriteCount' => $favorite_count,
        ]);
    }
}
