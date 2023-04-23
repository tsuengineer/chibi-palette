<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Show the search form.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('search.index');
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $posts = Post::with('user', 'user.avatars')
            ->where('title', 'like', "%{$keyword}%")
            ->orWhere('description', 'like', "%{$keyword}%")
            ->orderBy('created_at', 'desc')
            ->paginate(40);

        return view('search.results', [
            'posts' => $posts,
            'keyword' => $keyword,
        ]);
    }

    public function filterByTag(Request $request, $tag)
    {
        $posts = Post::whereHas('tags', function ($query) use ($tag) {
            $query->where('name', $tag);
        })->orderBy('created_at', 'desc')->paginate(40);

        return view('search.results', [
            'posts' => $posts,
            'tag' => $tag
        ]);
    }
}
