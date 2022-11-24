<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerOrderCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_order_codes', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('shop_group_id')->comment('價格分組ID');
            $table->unsignedInteger('product_id')->comment('內聯網貨品ID');

            $table->foreign('shop_group_id')
                ->references('id')
                ->on('shop_groups')
                ->onDelete('cascade');

            $table->foreign('product_id')
                ->references('id')
                ->on('workshop_products')
                ->onDelete('cascade');

            $table->string('customer_order_code')->comment('外客用產品編號');
            $table->timestamps();
        });

        Schema::table('customer_order_codes', function ($table) {
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
        Schema::dropIfExists('customer_order_codes');
    }
}
