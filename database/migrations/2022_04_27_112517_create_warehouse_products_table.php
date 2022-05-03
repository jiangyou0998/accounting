<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehouseProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouse_products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('product_name')->comment('貨品名');
            $table->string('product_name_short')->comment('簡略名稱');
            $table->string('product_no')->comment('貨品編號');
            $table->string('barcode')->comment('貨品barcode');
            $table->integer('supplier_id')->comment('供應商ID');
            $table->integer('group_id')->comment('供應商分組ID');
            $table->integer('unit_id')->comment('單位ID');
            $table->integer('base_unit_id')->nullable()->comment('包裝單位ID');
            $table->decimal('base_qty',10,2)->nullable()->comment('包裝數量');
            $table->decimal('default_price',10,2)->comment('價錢');
            $table->boolean('status')->default(0)->comment('狀態 0-啟用 1-禁用');
            $table->decimal('weight',10,2)->nullable()->comment('重量');
            $table->string('weight_unit')->nullable()->comment('重量單位');
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
        Schema::dropIfExists('warehouse_products');
    }
}
