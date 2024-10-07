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
        Schema::table('applications', function (Blueprint $table) {
            $table->integer('state_income_tax')->default(5);
            $table->integer('soc_sec_npf_tax')->default(0);
            $table->integer('employer_contribution')->default(0)->comment('Employer Contribution in Percent');
            $table->integer('icf_amount')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
