<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClaimLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('claim_levels', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('plan_no')->comment('索償計劃編號');
            $table->decimal('max_claim_money',10,2)->comment('索償金額上限');
            $table->integer('rate')->comment('索償百分比');
            $table->string('type_name',20)->comment('索償類別');
            $table->integer('times_per_day')->comment('每日申請上限');
            $table->integer('times_per_year')->comment('每年申請上限');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('claim_levels');
    }
}
