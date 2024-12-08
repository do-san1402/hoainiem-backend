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
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('post_id')->nullable()->comment('References the posts table');
            $table->unsignedBigInteger('comment_id')->nullable()->comment('References the comments table');
            $table->enum('type', ['post', 'comment'])->comment('Indicates whether the like is for a post or comment');
            $table->timestamps();

            $table->foreign('post_id')->references('id')->on('news_msts')->onDelete('cascade');
            $table->foreign('comment_id')->references('id')->on('comments')->onDelete('cascade');

            $table->unique(['user_id', 'post_id', 'comment_id'], 'unique_like');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('likes', function (Blueprint $table) {
            Schema::dropIfExists('likes');
        });
    }
};
