<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblOrderCheckTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_order_check', function (Blueprint $table) {
            $table->increments('int_id');
            $table->integer('int_all_shop')->default('1')->nullable();
            $table->longText('chr_shop_list')->nullable();
            $table->longText('chr_item_list')->nullable();
            $table->string('chr_report_name')->nullable();
            $table->integer('int_num_of_day')->default('1')->nullable();
            $table->integer('int_hide')->default('1')->nullable();
            $table->integer('int_main_item')->default('1')->nullable();
            $table->integer('int_sort')->default('1')->nullable();
            $table->integer('disabled')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_order_check');
    }
}
