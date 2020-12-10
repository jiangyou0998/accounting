<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameTblItsupportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('tbl_itsupport', function (Blueprint $table) {
            Schema::rename('tbl_itsupport', 'itsupports');
        });

        Schema::table('itsupports', function (Blueprint $table) {
            $table->renameColumn('int_id','id');
            $table->renameColumn('chr_no','it_support_no');
            $table->renameColumn('chr_ip','ip');
            $table->renameColumn('int_user','user_id');
            $table->renameColumn('int_itsupport_item','itsupport_item_id');
            $table->renameColumn('int_itsupport_detail','itsupport_detail_id');
            $table->renameColumn('int_important','importance');
            $table->renameColumn('int_status','status');
            $table->renameColumn('chr_machine_code','machine_code');
            $table->renameColumn('chr_other','other');
            $table->renameColumn('chr_pic','file_path');
            $table->renameColumn('txt_comment','comment');
            $table->renameColumn('report_date','created_at');
            $table->renameColumn('last_update_date','updated_at');
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
