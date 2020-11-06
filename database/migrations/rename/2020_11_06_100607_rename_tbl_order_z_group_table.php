<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameTblOrderZGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('tbl_order_z_group', function (Blueprint $table) {
            Schema::rename('tbl_order_z_group', 'workshop_groups');
        });

        Schema::table('workshop_groups', function (Blueprint $table) {
            $table->renameColumn('int_id','id');
            $table->renameColumn('chr_name','group_name');
            $table->renameColumn('int_sort','sort');
            $table->renameColumn('int_cat','cat_id');
            $table->renameColumn('chr_name_long','short_name');
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
