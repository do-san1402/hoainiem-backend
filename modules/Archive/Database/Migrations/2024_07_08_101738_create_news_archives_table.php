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
        Schema::create('news_archives', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->integer('news_id');
            $table->string('encode_title', 200);
            $table->text('seo_title')->nullable();
            $table->string('stitle', 100)->nullable();
            $table->string('title', 255)->nullable();
            $table->longText('news');
            $table->string('image', 250)->nullable();
            $table->string('image_base_url', 250)->nullable();
            $table->string('videos', 250)->nullable();
            $table->integer('podcust_id')->nullable();
            $table->string('image_alt', 200)->nullable();
            $table->string('image_title', 200)->nullable();
            $table->string('reporter', 56)->nullable();
            $table->string('page', 255)->nullable();
            $table->string('reference', 100)->nullable();
            $table->string('ref_date', 56)->nullable();
            $table->string('post_by', 56)->nullable();
            $table->string('update_by', 56)->nullable();
            $table->integer('time_stamp')->nullable();
            $table->date('post_date')->nullable();
            $table->date('publish_date')->nullable();
            $table->dateTime('last_update');
            $table->integer('is_latest')->nullable();
            $table->integer('reader_hit')->nullable();
            $table->tinyInteger('status')->nullable();
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
        Schema::dropIfExists('news_archives');
    }
};
