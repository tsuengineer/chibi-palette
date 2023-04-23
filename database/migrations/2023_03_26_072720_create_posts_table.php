<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->ulid('ulid')->unique()->comment('ULID');
            $table->string('title', 100)->comment('イラストのタイトル');
            $table->text('prompt')->nullable()->comment('プロンプト');
            $table->text('negative_prompt')->nullable()->comment('ネガティブプロンプト');
            $table->boolean('visibility_prompt')->default(1)->comment('プロンプト公開フラグ');
            $table->string('steps', 10)->nullable()->comment('Sampling steps');
            $table->string('scale', 10)->nullable()->comment('CFG Scale');
            $table->string('seed', 100)->nullable()->comment('Seed');
            $table->string('sampler', 100)->nullable()->comment('Sampling method');
            $table->string('strength', 10)->nullable()->comment('Strength');
            $table->string('noise', 10)->nullable()->comment('Noise');
            $table->string('model', 255)->nullable()->comment('Model');
            $table->integer('ai_model_id')->comment('使用AIのID');
            $table->text('description')->nullable()->comment('説明文');
            $table->string('tweet')->nullable()->comment('関連ツイートURL');
            $table->integer('views')->default(0);
            $table->tinyInteger('status')->default(1)->comment('公開状態などを管理 1:公開 2:停止 3:凍結');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
