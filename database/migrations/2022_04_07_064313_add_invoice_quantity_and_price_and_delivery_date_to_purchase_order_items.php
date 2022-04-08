<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInvoiceQuantityAndPriceAndDeliveryDateToPurchaseOrderItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_order_items', function (Blueprint $table) {
            $table->integer('invoiceQuantity')->nullable();
            $table->double('invoicePrice')->nullable();
            $table->string('deliveryDate')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_order_items', function (Blueprint $table) {
            $table->dropColumn('invoiceQuantity');
            $table->dropColumn('invoicePrice');
            $table->dropColumn('deliveryDate');
        });
    }
}
