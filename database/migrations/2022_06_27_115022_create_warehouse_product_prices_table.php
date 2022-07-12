<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehouseProductPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouse_product_prices', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('price',10,2);
            $table->decimal('base_price',10,2);
            $table->unsignedInteger('product_id');
            $table->foreign('product_id')->references('id')->on('warehouse_products')->onDelete('cascade');
            $table->integer('sort');
            $table->date('start_date');
            $table->date('end_date');
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
        Schema::dropIfExists('warehouse_product_prices');
    }
}
