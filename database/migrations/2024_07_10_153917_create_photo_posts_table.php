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
        Schema::create('photo_posts', function (Blueprint $table) {
            $table->id();
            $table->string('stitle', 255)->nullable();
            $table->string('title', 255)->nullable();
            $table->text('details')->nullable();
            $table->string('reporter', 255)->nullable();
            $table->string('category', 255)->nullable();
            $table->bigInteger('post_by')->nullable();
            $table->bigInteger('update_by')->nullable();
            $table->string('meta_keyword', 255)->nullable();
            $table->string('meta_description', 255)->nullable();
            $table->tinyInteger('status')->nullable();
            $table->integer('timestamp')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photo_posts');
    }
};
