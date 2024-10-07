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
        Schema::create('news_msts', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->bigInteger('news_id');
            $table->string('encode_title', 200);
            $table->text('seo_title')->nullable();
            $table->string('stitle', 255)->nullable();
            $table->string('title', 255)->nullable();
            $table->longText('news');
            $table->string('image', 250)->nullable();
            $table->string('image_base_url', 250)->nullable();
            $table->string('videos', 250)->nullable();
            $table->bigInteger('podcust_id')->nullable()->nullable();
            $table->string('image_alt', 250)->nullable();
            $table->string('reporter', 250)->nullable();
            $table->string('page', 250)->nullable();
            $table->string('reference', 250)->nullable();
            $table->date('ref_date')->nullable();
            $table->string('post_by', 250)->nullable();
            $table->bigInteger('reporter_id')->nullable();
            $table->string('update_by', 250)->nullable();
            $table->integer('time_stamp')->nullable();
            $table->date('post_date')->nullable();
            $table->date('publish_date')->nullable();
            $table->dateTime('last_update');
            $table->bigInteger('is_latest')->nullable();
            $table->bigInteger('reader_hit')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news_msts');
    }
};
