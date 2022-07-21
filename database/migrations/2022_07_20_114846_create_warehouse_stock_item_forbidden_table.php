<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehouseStockItemForbiddenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouse_stock_item_forbidden', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->comment('操作用戶ID');
            $table->integer('month')->comment('操作月份');
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
        Schema::dropIfExists('warehouse_stock_item_forbidden');
    }
}
