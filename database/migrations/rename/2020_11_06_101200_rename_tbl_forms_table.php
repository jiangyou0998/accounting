<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameTblFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('tbl_forms', function (Blueprint $table) {
            Schema::rename('tbl_forms', 'forms');
        });

        Schema::table('forms', function (Blueprint $table) {
            $table->renameColumn('int_id','id');
            $table->renameColumn('txt_name','form_name');
            $table->renameColumn('int_dept','admin_role_id');
            $table->renameColumn('txt_path','file_path');
            $table->renameColumn('int_user','user_id');
            $table->renameColumn('date_create','created_date');
            $table->renameColumn('date_modify','modify_date');
            $table->renameColumn('date_delete','deleted_date');
            $table->renameColumn('int_no','form_no');
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
