<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCataloguesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_catalogues', function (Blueprint $table) {
            $table->id();
            $table->string('siteCode')->nullable();
            $table->string('modelCode');
            $table->string('modelDesc');
            $table->double('price');
            $table->double('discount');
            $table->string('status');
            $table->string('startDate');
            $table->string('endDate');
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
        Schema::dropIfExists('product_catalogues');
    }
}
