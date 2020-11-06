<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameTblOrderZUnitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('tbl_order_z_unit', function (Blueprint $table) {
            Schema::rename('tbl_order_z_unit', 'workshop_units');
        });

        Schema::table('workshop_units', function (Blueprint $table) {
            $table->renameColumn('int_id','id');
            $table->renameColumn('chr_name','unit_name');
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
