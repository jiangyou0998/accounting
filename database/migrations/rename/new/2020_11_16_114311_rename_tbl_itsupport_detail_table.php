<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameTblItsupportDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('tbl_itsupport_detail', function (Blueprint $table) {
            Schema::rename('tbl_itsupport_detail', 'itsupport_details');
        });

        Schema::table('itsupport_details', function (Blueprint $table) {
            $table->renameColumn('int_id','id');
            $table->renameColumn('chr_name','name');
            $table->renameColumn('int_sort','sort');
            $table->renameColumn('int_item_id','item_id');
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
