<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesDataChangeApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_data_change_applications', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date')->comment('修改日期');
            $table->integer('shop_id')->comment('分店ID');
            $table->integer('handle_user')->nullable()->comment('授權用戶');
            $table->date('handle_date')->nullable()->comment('可操作日期,為區長同意後一日內');
            $table->integer('status')->default(0)->comment('0-申請中,1-同意,2-不同意');
            $table->timestamps();
        });

        Schema::table('sales_data_change_applications', function ($table) {
            $table->dateTime('created_at')->change();
            $table->dateTime('updated_at')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales_data_change_applications');
    }
}
