<?php

namespace App\Http\Controllers;

use App\Models\Ranking;

class RankingController extends Controller
{
    public function index()
    {
        $post_weekly_likes = Ranking::with('post', 'post.user', 'post.user.avatars')
            ->where('ranking_type', 'post_weekly_likes')
            ->get();
        $post_weekly_access = Ranking::with('post', 'post.user', 'post.user.avatars')
            ->where('ranking_type', 'post_weekly_access')
            ->get();
        $user_weekly_likes = Ranking::with('user', 'user.avatars')
            ->where('ranking_type', 'user_weekly_likes')
            ->get();
        $user_weekly_access = Ranking::with('user', 'user.avatars')
            ->where('ranking_type', 'user_weekly_Access')
            ->get();

        $post_monthly_likes = Ranking::with('post', 'post.user', 'post.user.avatars')
            ->where('ranking_type', 'post_monthly_likes')
            ->get();
        $post_monthly_access = Ranking::with('post', 'post.user', 'post.user.avatars')
            ->where('ranking_type', 'post_monthly_access')
            ->get();
        $user_monthly_likes = Ranking::with('user', 'user.avatars')
            ->where('ranking_type', 'user_monthly_likes')
            ->get();
        $user_monthly_access = Ranking::with('user', 'user.avatars')
            ->where('ranking_type', 'user_monthly_Access')
            ->get();

        return view('ranking.index', [
            'postWeeklyLikes' => $post_weekly_likes,
            'postWeeklyAccess' => $post_weekly_access,
            'userWeeklyLikes' => $user_weekly_likes,
            'userWeeklyAccess' => $user_weekly_access,
            'postMonthlyLikes' => $post_monthly_likes,
            'postMonthlyAccess' => $post_monthly_access,
            'userMonthlyLikes' => $user_monthly_likes,
            'userMonthlyAccess' => $user_monthly_access,
        ]);
    }
}
