<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_bills', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sales_cal_result_id');
            $table->integer('shop_id')->comment('分店ID');
            $table->date('date')->comment('日期');
            $table->integer('bill_no')->comment('支單編號');
            $table->decimal('outlay',10,2)->comment('支出');
            $table->string('detail',200)->nullable()->comment('明細');
            $table->string('file_path')->nullable()->comment('圖片路徑');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales_bills');
    }
}
