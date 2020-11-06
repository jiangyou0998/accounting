<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameTblOrderSampleItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('tbl_order_sample_item', function (Blueprint $table) {
            Schema::rename('tbl_order_sample_item', 'workshop_order_sample_item');
        });

        Schema::table('workshop_order_sample_item', function (Blueprint $table) {
            $table->renameColumn('menu_id','product_id');
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
