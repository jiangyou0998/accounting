<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesIncomeDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_income_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sales_cal_result_id');
            $table->integer('type_no')->comment('類型');
            $table->decimal('income',10,2)->comment('收入');
            $table->string('remark',20)->comment('備註');
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
        Schema::dropIfExists('sales_income_details');
    }
}
