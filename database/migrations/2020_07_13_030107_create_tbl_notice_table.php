<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblNoticeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_notice', function (Blueprint $table) {
            $table->increments('int_id');
            $table->text('txt_name')->nullable();
            $table->unsignedInteger('int_dept')->nullable();
            $table->text('txt_path')->nullable();
            $table->unsignedInteger('int_user')->nullable();
            $table->date('date_create')->nullable();
            $table->date('date_modify')->nullable();
            $table->date('date_delete')->nullable();
            $table->unsignedInteger('int_no')->default('0')->nullable();
            $table->date('date_last')->nullable();
            $table->text('first_path')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_notice');
    }
}
