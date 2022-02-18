<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesCalResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_cal_results', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('first_pos_no')->comment('主機NO');
            $table->integer('second_pos_no')->comment('副機NO')->nullable();
            $table->integer('deposit_no')->comment('存單編號');
            $table->integer('shop_id')->comment('分店ID');
            $table->date('date')->comment('日期');
            $table->decimal('balance',10,2)->comment('結存');
            $table->decimal('safe_balance',10,2)->comment('夾萬結存');
            $table->decimal('last_balance',10,2)->comment('承上結存');
            $table->decimal('last_safe_balance',10,2)->comment('夾萬承上結存');
            $table->decimal('bill_paid_sum',10,2)->comment('支單總額');
            $table->decimal('income_sum',10,2)->comment('收入');
            $table->decimal('difference',10,2)->comment('差額');

            $table->unique(['shop_id', 'date'], 'sales_cal_results_shop_id_date_unique');

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
        Schema::dropIfExists('sales_cal_results');
    }
}
