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
        Schema::create('top_breakings', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('category_slug', 100)->nullable();
            $table->string('title', 100)->nullable();
            $table->string('background_color', 200)->nullable();
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('top_breakings');
    }
};
