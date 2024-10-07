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
        Schema::create('ad_s', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->integer('page');
            $table->integer('ad_position');
            $table->text('embed_code');
            $table->integer('large_status')->default(1);
            $table->integer('mobile_status')->default(1);
            $table->string('theme', 100);
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
        Schema::dropIfExists('ad_s');
    }
};
