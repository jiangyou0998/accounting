<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameTblOrderZMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('tbl_order_z_menu', function (Blueprint $table) {
            Schema::rename('tbl_order_z_menu', 'workshop_products');
        });

        Schema::table('workshop_products', function (Blueprint $table) {
            $table->renameColumn('int_id','id');
            $table->renameColumn('chr_name','product_name');
            $table->renameColumn('chr_no','product_no');
            $table->renameColumn('int_group','group_id');
            $table->renameColumn('int_unit','unit_id');
            $table->renameColumn('int_base','base');
            $table->renameColumn('int_min','min');
            $table->renameColumn('int_default_price','default_price');
            $table->renameColumn('int_sort','sort');
            $table->renameColumn('int_phase','phase');
            $table->renameColumn('chr_image','image');
            $table->renameColumn('chr_cuttime','cuttime');
            $table->renameColumn('chr_canordertime','canordertime');
            $table->dateTime('created_at')->nullable()->default(null);
            $table->dateTime('updated_at')->nullable()->default(null);
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
