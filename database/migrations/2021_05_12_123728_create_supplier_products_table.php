<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('product_name');
            $table->string('product_no');
            $table->integer('supplier_id');
            $table->integer('group_id');
            $table->integer('unit_id');
            $table->integer('base_unit_id');
            $table->decimal('base_qty',10,2);
            $table->decimal('default_price',10,2);
            $table->boolean('disabled')->default(0);
            $table->decimal('weight',10,2);
            $table->string('weight_unit');
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
        Schema::dropIfExists('supplier_products');
    }
}
