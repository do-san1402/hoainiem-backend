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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->integer('category_id');
            $table->text('category_name');
            $table->text('slug');
            $table->integer('menu')->default(0);
            $table->integer('position')->default(1);
            $table->string('parents_id', 200)->nullable();
            $table->text('category_imgae')->nullable();
            $table->tinyInteger('img_status')->default(0);
            $table->integer('category_type')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('categories');
    }
};
