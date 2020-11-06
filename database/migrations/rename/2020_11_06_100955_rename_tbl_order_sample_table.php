<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameTblOrderSampleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('tbl_order_sample', function (Blueprint $table) {
            Schema::rename('tbl_order_sample', 'workshop_order_sample');
        });

        Schema::table('workshop_order_sample', function (Blueprint $table) {
            $table->string('dept',2)->nullable()->default('R');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
