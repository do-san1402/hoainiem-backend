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
        Schema::create('prefixes', function (Blueprint $table) {
            $table->id();
            $table->string('purchase_requisition_no')->nullable();
            $table->string('purchase_no')->nullable();
            $table->string('purchase_received_no')->nullable();
            $table->string('purchase_return_no')->nullable();
            $table->string('sale_quotation_no')->nullable();
            $table->string('sale_invoice_no')->nullable();
            $table->string('sale_draft_no')->nullable();
            $table->string('sale_return_no')->nullable();
            $table->string('stock_adjustment_no')->nullable();
            $table->string('wastage_no')->nullable();
            $table->string('delivery_no')->nullable();
            $table->string('employee_id')->nullable();
            $table->string('service_invoice_no')->nullable();
            $table->string('transfer_no')->nullable();
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
        Schema::dropIfExists('prefixes');
    }
};
