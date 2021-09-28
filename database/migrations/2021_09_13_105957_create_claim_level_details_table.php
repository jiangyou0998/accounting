<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClaimLevelDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('claim_level_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('claim_level_id');
            $table->decimal('max_claim_money',10,2)->comment('索償金額上限');
            $table->integer('rate')->comment('索償百分比');
            $table->integer('times_per_day')->comment('每日申請上限');
            $table->integer('times_per_year')->comment('每年申請上限');
            $table->date('start_date')->comment('開始日期');
            $table->date('end_date')->comment('結束日期');

            $table->foreign('claim_level_id')
                ->references('id')
                ->on('claim_levels')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('claim_level_details');
    }
}
