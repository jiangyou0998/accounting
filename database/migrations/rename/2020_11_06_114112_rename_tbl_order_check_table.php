<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameTblOrderCheckTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('tbl_order_check', function (Blueprint $table) {
            Schema::rename('tbl_order_check', 'workshop_checks');
        });

        Schema::table('workshop_checks', function (Blueprint $table) {
            $table->renameColumn('int_id','id');
            $table->renameColumn('chr_shop_list','shop_list');
            $table->renameColumn('chr_item_list','item_list');
            $table->renameColumn('chr_report_name','report_name');
            $table->renameColumn('int_num_of_day','num_of_day');
            $table->renameColumn('int_sort','sort');
//            $table->dateTime('created_at')->nullable()->default(null);
//            $table->dateTime('updated_at')->nullable()->default(null);
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
