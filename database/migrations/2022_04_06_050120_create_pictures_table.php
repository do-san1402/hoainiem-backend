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
        Schema::create('pictures', function (Blueprint $table) {
            $table->id();
            $table->morphs('imageable');
            $table->string('name')->nullable();
            $table->string('file_name')->nullable();
            $table->string('mime_type')->nullable();
            $table->boolean('featured')->default(0);
            $table->text('febicon')->nullable();
            $table->text('thumbnail')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0=Inactive , 1=Active');
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
        Schema::dropIfExists('pictures');
    }
};
