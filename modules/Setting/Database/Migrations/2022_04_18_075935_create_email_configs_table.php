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
        Schema::create('email_configs', function (Blueprint $table) {
            $table->id();
            $table->text('protocol');
            $table->text('smtp_host');
            $table->text('smtp_port');
            $table->string('smtp_user');
            $table->string('smtp_pass');
            $table->string('mailtype');
            $table->tinyInteger('isinvoice');
            $table->tinyInteger('isservice');
            $table->tinyInteger('isquotation');
            $table->timestamps();
            $table->softdeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('email_configs');
    }
};
