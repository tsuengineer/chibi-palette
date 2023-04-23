<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ai_models', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // AIモデルの初期データを追加
        $ai_models = [
            ['name' => 'NovelAI'],
            ['name' => 'Stable Diffusion'],
            ['name' => 'Midjourney'],
            ['name' => 'niji journey'],
            ['name' => 'Holara'],
        ];

        DB::table('ai_models')->insert($ai_models);

        // IDが999のレコードを追加
        DB::table('ai_models')->insert([
            'id' => 999,
            'name' => 'その他',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_models');
    }
};
