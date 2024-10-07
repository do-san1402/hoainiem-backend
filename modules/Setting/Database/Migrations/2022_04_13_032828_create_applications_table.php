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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->integer('language_id')->nullable();
            $table->integer('currency_id')->nullable();
            $table->string('title')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('prefix')->nullable();
            $table->text('address')->nullable();
            $table->string('tax_no')->nullable();
            $table->tinyInteger('rtl_ltr')->default(1)->comment('1=LTR,2=RTL');
            $table->tinyInteger('negative_amount_symbol')->default(1)->comment('1=-,2=()');
            $table->tinyInteger('floating_number')->default(1)->comment('1 = 0, 2 = 0.0 ,3= 0.00, 4= 0.000 ');
            $table->boolean('fixed_date')->default(0);
            $table->string('footer_text');
            $table->string('logo')->nullable();
            $table->string('sidebar_logo')->nullable();
            $table->string('favicon')->nullable();
            $table->string('sidebar_collapsed_logo')->nullable();
            $table->string('login_image')->nullable();
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
        Schema::dropIfExists('applications');
    }
};
