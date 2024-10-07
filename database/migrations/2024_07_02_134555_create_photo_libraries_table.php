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
        Schema::create('photo_libraries', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('image_base_url')->nullable();
            $table->string('actual_image_name');
            $table->string('picture_name')->nullable();
            $table->string('thumb_image')->nullable();
            $table->string('large_image')->nullable();
            $table->string('title')->nullable();
            $table->bigInteger('category')->nullable();
            $table->string('reference')->nullable();
            $table->integer('time_stamp')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photo_libraries');
    }
};
