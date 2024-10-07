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
        Schema::create('home_page_positions', function (Blueprint $table) {
            $table->id();
            $table->string('cat_name', 200)->nullable();
            $table->string('slug', 200)->nullable();
            $table->string('max_news', 200)->nullable();
            $table->bigInteger('category_id');
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_page_positions');
    }
};
