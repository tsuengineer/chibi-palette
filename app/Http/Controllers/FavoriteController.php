<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Favorite;

class FavoriteController extends Controller
{
    /**
     * お気に入り一覧を表示する
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $favorites = Auth::user()->favorites()->with('post')->get();

        return view('favorites.index', compact('favorites'));
    }

    /**
     * お気に入りを追加する
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Auth::id()) {
            return response()->json([
                'success' => false,
            ]);
        }
        $user_id = Auth::id();
        $post_id = $request->input('post_id');

        // 既にお気に入りに追加されているかどうかを確認する
        $is_favorite = Favorite::where('post_id', $post_id)->where('user_id', $user_id)->exists();

        if (!$is_favorite) {
            $favorite = new Favorite;
            $favorite->user_id = $user_id;
            $favorite->post_id = $post_id;
            $favorite->save();
        }

        // お気に入りの総数を取得する
        $favorite_count = Favorite::where('post_id', $post_id)->count();

        return response()->json([
            'success' => true,
            'favorite_count' => $favorite_count
            ]);
    }

    /**
     * お気に入りを削除する
     *
     * @param  int $post_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($post_id)
    {
        if (!Auth::id()) {
            return response()->json([
                'success' => false,
            ]);
        }
        $favorite = Favorite::where('post_id', $post_id)
            ->where('user_id', Auth::user()->id)->first();

        if ($favorite) {
            $favorite->delete();
        }

        // お気に入りの総数を取得する
        $favorite_count = Favorite::where('post_id', $post_id)->count();

        return response()->json([
            'success' => true,
            'favorite_count' => $favorite_count
        ]);
    }
}
