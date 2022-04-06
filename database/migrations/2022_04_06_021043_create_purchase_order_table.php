<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('poNumber');
            $table->string('siteCode');
            $table->string('orderDate');
            $table->string('deliveryMode')->nullable();
            $table->string('paymentMethod')->nullable();
            $table->string('comment')->nullable();
            $table->string('sales_order')->nullable();
            $table->string('billing_document')->nullable();
            $table->string('api_order_id')->nullable();
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
        Schema::dropIfExists('purchase_orders');
    }
}
