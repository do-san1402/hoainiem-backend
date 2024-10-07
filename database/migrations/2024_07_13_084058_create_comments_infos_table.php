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
        Schema::create('comments_infos', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->integer('com_id');
            $table->text('comments');
            $table->integer('com_rating')->nullable();
            $table->string('news_id', 255);
            $table->integer('com_user_id');
            $table->integer('com_replay_id');
            $table->string('com_date_time', 50);
            $table->integer('com_type')->nullable();
            $table->integer('com_status');
            $table->updateCreatedBy();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments_infos');
    }
};
