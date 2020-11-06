<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameTblOrderZCatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('tbl_order_z_cat', function (Blueprint $table) {
            Schema::rename('tbl_order_z_cat', 'workshop_cats');
        });

        Schema::table('workshop_cats', function (Blueprint $table) {
            $table->renameColumn('int_id','id');
            $table->renameColumn('chr_name','cat_name');
            $table->renameColumn('int_sort','sort');
            $table->renameColumn('start_time','start_date');
            $table->renameColumn('end_time','end_date');
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
