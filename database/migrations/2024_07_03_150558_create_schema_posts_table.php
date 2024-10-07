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
        Schema::create('schema_posts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('news_id')->nullable();
            $table->string('type')->nullable();
            $table->string('url')->nullable();
            $table->string('headline')->nullable();
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
            $table->string('author_type')->nullable();
            $table->string('author_name')->nullable();
            $table->string('publisher')->nullable();
            $table->string('publisher_logo')->nullable();
            $table->date('publishdate')->nullable();
            $table->date('modifidate')->nullable();
            $table->tinyInteger('active_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schema_posts');
    }
};
