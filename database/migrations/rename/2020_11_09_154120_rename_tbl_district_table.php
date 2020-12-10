<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameTblDistrictTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('tbl_district', function (Blueprint $table) {
            Schema::rename('tbl_district', 'shop_address');
        });

        Schema::table('shop_address', function (Blueprint $table) {
            $table->renameColumn('int_id','id');
            $table->renameColumn('chr_name','shop_name');
            $table->renameColumn('chr_tel','tel');
            $table->renameColumn('chr_fax','fax');
            $table->renameColumn('chr_address','address');
            $table->renameColumn('chr_eng_address','eng_address');
            $table->renameColumn('chr_code','code');
            $table->renameColumn('chr_oper_time','oper_time');
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
