<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_emails', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 40)->comment('名稱');
            $table->string('email', 100)->comment('電郵地址');
            $table->string('type', 40)->comment('通知電郵類型');
            $table->boolean('is_test')->comment('是否測試環境用,0-是,1-否');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notification_emails');
    }
}
