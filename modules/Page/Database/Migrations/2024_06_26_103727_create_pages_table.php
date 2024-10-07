<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->integer('page_id');
            $table->text('title')->nullable();
            $table->text('page_slug')->nullable();
            $table->longText('description')->nullable();
            $table->string('image_id', 100)->nullable();
            $table->integer('galary_id')->nullable();
            $table->string('video_url', 100)->nullable();
            $table->integer('publishar_id')->nullable();
            $table->text('seo_keyword')->nullable();
            $table->text('seo_description')->nullable();
            $table->dateTime('publish_date')->nullable();
            $table->integer('reader_view')->nullable();
            $table->string('releted_id', 255)->nullable();
            $table->integer('status')->default(1);
            $table->updateCreatedBy();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
    }
};
