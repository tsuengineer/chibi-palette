<?php

namespace App\Http\Controllers;

use App\Models\Post;

class TopController extends Controller
{
    public function index()
    {
        $posts = Post::with('user', 'user.avatars')
            ->orderBy('created_at', 'desc')
            ->paginate(40);

        return view('top.index', [
            'posts' => $posts,
        ]);
    }
}
