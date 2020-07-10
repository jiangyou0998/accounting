<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblOrderZCatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_order_z_cat', function (Blueprint $table) {
            $table->increments('id');
            $table->string('chr_name')->default('');
            $table->unsignedInteger('int_sort');
            $table->unsignedInteger('status');
            $table->unsignedInteger('int_page');
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
        Schema::dropIfExists('tbl_order_z_cat');
    }
}
