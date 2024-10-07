<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_contents', function (Blueprint $table) {
            $table->id();
            $table->text('content_type')->nullable();
            $table->bigInteger('content_id')->nullable();
            $table->integer('menu_position')->nullable();
            $table->string('menu_level', 255)->nullable();
            $table->string('link_url', 255)->nullable();
            $table->text('slug')->nullable();
            $table->bigInteger('parent_id')->nullable();
            $table->bigInteger('menu_id')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu_contents');
    }
};
