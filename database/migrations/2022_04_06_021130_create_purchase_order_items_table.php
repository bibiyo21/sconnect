<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_order_items', function (Blueprint $table) {
            $table->id();
            $table->integer('purchase_order_id');
            $table->string('bundleCode')->nullable();
            $table->string('modelCode');
            $table->integer('orderQuantity');
            $table->double('price');
            $table->double('discount')->nullable();
            $table->double('discountedPrice')->nullable();
            $table->double('totalPrice')->nullable();
            $table->string('taxcode');
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
        Schema::dropIfExists('purchase_order_items');
    }
}
