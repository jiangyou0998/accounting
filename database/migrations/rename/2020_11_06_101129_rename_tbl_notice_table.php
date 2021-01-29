<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameTblNoticeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_notice', function (Blueprint $table) {
            Schema::rename('tbl_notice', 'notices');
        });

        Schema::table('notices', function (Blueprint $table) {
            $table->renameColumn('int_id','id');
            $table->renameColumn('txt_name','notice_name');
            $table->renameColumn('int_dept','admin_role_id');
            $table->renameColumn('txt_path','file_path');
            $table->renameColumn('int_user','user_id');
            $table->renameColumn('date_create','created_at');
            $table->renameColumn('date_modify','updated_at');
            $table->renameColumn('date_delete','deleted_at');
            $table->renameColumn('int_no','notice_no');
            $table->renameColumn('date_last','expired_date');
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
