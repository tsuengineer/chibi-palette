<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ranking extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:ranking';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ランキング用テーブルに集計する';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $ranking_controller = app()->make('App\Http\Controllers\Api\RankingController');
        $ranking_controller->ranking();

        return true;
    }
}
