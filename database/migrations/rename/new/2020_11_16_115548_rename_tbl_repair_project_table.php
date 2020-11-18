<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameTblRepairProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('tbl_repair_project', function (Blueprint $table) {
            Schema::rename('tbl_repair_project', 'repair_projects');
        });

        Schema::table('repair_projects', function (Blueprint $table) {
            $table->renameColumn('int_id','id');
            $table->renameColumn('chr_no','repair_project_no');
            $table->renameColumn('chr_ip','ip');
            $table->renameColumn('int_user','user_id');
            $table->renameColumn('int_repair_loc','repair_location_id');
            $table->renameColumn('int_repair_item','repair_item_id');
            $table->renameColumn('int_repair_detail','repair_detail_id');
            $table->renameColumn('int_important','importance');
            $table->renameColumn('int_status','status');
            $table->renameColumn('chr_machine_code','machine_code');
            $table->renameColumn('chr_other','other');
            $table->renameColumn('chr_pic','picture_path');
            $table->renameColumn('txt_comment','comment');
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
