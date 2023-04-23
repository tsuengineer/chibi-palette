<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AccessLog;
use App\Models\Favorite;
use App\Models\Ranking;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RankingController extends Controller
{
    public function ranking()
    {
        // rankingsテーブルを空にする
        Ranking::truncate();

        // 現在の日付を取得
        $currentDate = Carbon::now();
        $oneDaysAgo = clone $currentDate; // 修正: clone を使用してオリジナルの $currentDate を保持
        $oneDaysAgo->subDays(1); // 修正: subDays() メソッドを使って日付を減算
        $sevenDaysAgo = clone $currentDate; // 修正: clone を使用してオリジナルの $currentDate を保持
        $sevenDaysAgo->subDays(7); // 修正: subDays() メソッドを使って日付を減算
        $thirtyDaysAgo = clone $currentDate; // 修正: clone を使用してオリジナルの $currentDate を保持
        $thirtyDaysAgo->subDays(30); // 修正: subDays() メソッドを使って日付を減算

        // 直近1日でいいね数の上位10件のイラストを取得
        $postDailyLikesRanking = Favorite::with('post')
            ->select('post_id', DB::raw('count(*) as favorites_count'))
            ->whereBetween('created_at', [$oneDaysAgo, $currentDate])
            ->groupBy('post_id')
            ->having('favorites_count', '>', 0)
            ->orderByDesc('favorites_count')
            ->limit(10)
            ->get();

        // 直近7日でいいね数の上位10件のイラストを取得
        $postWeeklyLikesRanking = Favorite::with('post')
            ->select('post_id', DB::raw('count(*) as favorites_count'))
            ->whereBetween('created_at', [$sevenDaysAgo, $currentDate])
            ->groupBy('post_id')
            ->having('favorites_count', '>', 0)
            ->orderByDesc('favorites_count')
            ->limit(10)
            ->get();

        // 直近30日でいいね数の上位10件のイラストを取得
        $postMonthlyLikesRanking = Favorite::with('post')
            ->select('post_id', DB::raw('count(*) as favorites_count'))
            ->whereBetween('created_at', [$thirtyDaysAgo, $currentDate])
            ->groupBy('post_id')
            ->having('favorites_count', '>', 0)
            ->orderByDesc('favorites_count')
            ->limit(10)
            ->get();


        // 直近1日でアクセス数の上位10件のイラストを取得
        $postDailyAccessRanking = AccessLog::select('post_id', DB::raw('COUNT(*) as access_count'))
            ->whereBetween('created_at', [$oneDaysAgo, $currentDate])
            ->groupBy('post_id')
            ->having('access_count', '>', 0)
            ->orderByDesc('access_count')
            ->limit(10)
            ->get();

        // 直近7日でいいね数の上位10件のイラストを取得
        $postWeeklyAccessRanking = AccessLog::select('post_id', DB::raw('COUNT(*) as access_count'))
            ->whereBetween('created_at', [$sevenDaysAgo, $currentDate])
            ->groupBy('post_id')
            ->having('access_count', '>', 0)
            ->orderByDesc('access_count')
            ->limit(10)
            ->get();

        // 直近30日でいいね数の上位10件のイラストを取得
        $postMonthlyAccessRanking = AccessLog::select('post_id', DB::raw('COUNT(*) as access_count'))
            ->whereBetween('created_at', [$thirtyDaysAgo, $currentDate])
            ->groupBy('post_id')
            ->having('access_count', '>', 0)
            ->orderByDesc('access_count')
            ->limit(10)
            ->get();

        // 直近1日でいいね数の上位10件のユーザーを取得
        $userDailyLikesRanking = DB::table('favorites')
            ->join('posts', 'favorites.post_id', '=', 'posts.id')
            ->select('posts.user_id', DB::raw('count(*) as favorites_count'))
            ->whereBetween('favorites.created_at', [$oneDaysAgo, $currentDate])
            ->groupBy('posts.user_id')
            ->having('favorites_count', '>', 0)
            ->orderByDesc('favorites_count')
            ->limit(10)
            ->get();

        // 直近7日でいいね数の上位10件のユーザーを取得
        $userWeeklyLikesRanking = DB::table('favorites')
            ->join('posts', 'favorites.post_id', '=', 'posts.id')
            ->select('posts.user_id', DB::raw('count(*) as favorites_count'))
            ->whereBetween('favorites.created_at', [$sevenDaysAgo, $currentDate])
            ->groupBy('posts.user_id')
            ->having('favorites_count', '>', 0)
            ->orderByDesc('favorites_count')
            ->limit(10)
            ->get();

        // 直近30日でいいね数の上位10件のユーザーを取得
        $userMonthlyLikesRanking = DB::table('favorites')
            ->join('posts', 'favorites.post_id', '=', 'posts.id')
            ->select('posts.user_id', DB::raw('count(*) as favorites_count'))
            ->whereBetween('favorites.created_at', [$thirtyDaysAgo, $currentDate])
            ->groupBy('posts.user_id')
            ->having('favorites_count', '>', 0)
            ->orderByDesc('favorites_count')
            ->limit(10)
            ->get();

        // 日次でアクセス数の上位10件のユーザーを取得
        $userDailyAccessRanking = AccessLog::select('posts.user_id', DB::raw('COUNT(*) as access_count'))
            ->join('posts', 'access_logs.post_id', '=', 'posts.id')
            ->whereBetween('access_logs.created_at', [$oneDaysAgo, $currentDate])
            ->groupBy('posts.user_id')
            ->having('access_count', '>', 0)
            ->orderByDesc('access_count')
            ->limit(10)
            ->get();

        // 週次でアクセス数の上位10件のユーザーを取得
        $userWeeklyAccessRanking = AccessLog::select('posts.user_id', DB::raw('COUNT(*) as access_count'))
            ->join('posts', 'access_logs.post_id', '=', 'posts.id')
            ->whereBetween('access_logs.created_at', [$sevenDaysAgo, $currentDate])
            ->groupBy('posts.user_id')
            ->having('access_count', '>', 0)
            ->orderByDesc('access_count')
            ->limit(10)
            ->get();

        // 月次でアクセス数の上位10件のユーザーを取得
        $userMonthlyAccessRanking = AccessLog::select('posts.user_id', DB::raw('COUNT(*) as access_count'))
            ->join('posts', 'access_logs.post_id', '=', 'posts.id')
            ->whereBetween('access_logs.created_at', [$thirtyDaysAgo, $currentDate])
            ->groupBy('posts.user_id')
            ->having('access_count', '>', 0)
            ->orderByDesc('access_count')
            ->limit(10)
            ->get();

        // rankingsテーブルに取得した値を設定する
        $this->saveRankingData($postDailyLikesRanking, 'post_daily_likes');
        $this->saveRankingData($postWeeklyLikesRanking, 'post_weekly_likes');
        $this->saveRankingData($postMonthlyLikesRanking, 'post_monthly_likes');
        $this->saveRankingData($postDailyAccessRanking, 'post_daily_access');
        $this->saveRankingData($postWeeklyAccessRanking, 'post_weekly_access');
        $this->saveRankingData($postMonthlyAccessRanking, 'post_monthly_access');
        $this->saveRankingData($userDailyLikesRanking, 'user_daily_likes');
        $this->saveRankingData($userWeeklyLikesRanking, 'user_weekly_likes');
        $this->saveRankingData($userMonthlyLikesRanking, 'user_monthly_likes');
        $this->saveRankingData($userDailyAccessRanking, 'user_daily_access');
        $this->saveRankingData($userWeeklyAccessRanking, 'user_weekly_access');
        $this->saveRankingData($userMonthlyAccessRanking, 'user_monthly_access');

        return true;
    }

    // ランキングデータを保存するメソッド
    private function saveRankingData($data, $rankingType)
    {
        $rankingOrder = 1;

        if (Str::startsWith($rankingType, 'post')) {
            foreach ($data as $item) {
                if (Str::endsWith($rankingType, 'likes')) {
                    $point = $item->favorites_count;
                } else {
                    $point = $item->access_count;
                }

                $ranking = new Ranking();
                $ranking->post_id = $item->post_id;
                $ranking->ranking_type = $rankingType;
                $ranking->ranking_order = $rankingOrder;
                $ranking->point = $point;
                $ranking->save();
                $rankingOrder++;
            }
        } elseif (Str::startsWith($rankingType, 'user')) {
            foreach ($data as $item) {
                if (Str::endsWith($rankingType, 'likes')) {
                    $point = $item->favorites_count;
                } else {
                    $point = $item->access_count;
                }

                $ranking = new Ranking();
                $ranking->user_id = $item->user_id;
                $ranking->ranking_type = $rankingType;
                $ranking->ranking_order = $rankingOrder;
                $ranking->point = $point;
                $ranking->save();
                $rankingOrder++;
            }
        }
    }
}
