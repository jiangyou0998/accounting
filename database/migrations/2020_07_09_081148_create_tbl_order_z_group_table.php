<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblOrderZGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_order_z_group', function (Blueprint $table) {
            $table->increments('int_id');
            $table->string('chr_name')->default('');
            $table->unsignedInteger('int_sort');
            $table->unsignedInteger('status')->default('1');
            $table->unsignedInteger('int_cat');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_order_z_group');
    }
}
