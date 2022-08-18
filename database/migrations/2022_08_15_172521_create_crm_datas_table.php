<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrmDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crm_datas', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('客戶編號');
            $table->string('name', 50)->comment('客戶名稱')->nullable();
            $table->string('level', 20)->comment('會員級別')->nullable();
            $table->string('sex', 10)->comment('性別')->nullable();
            $table->date('date_of_birth')->comment('出生日期')->nullable();
            $table->string('mobile', 50)->comment('移動電話')->nullable();
            $table->string('email', 100)->comment('電子郵箱')->nullable();
            $table->date('last_visit')->comment('最近一次光顧時間')->nullable();
            $table->date('create_date')->comment('創建日期')->nullable();
            $table->date('expiry_date')->comment('到期日期')->nullable();
            $table->integer('point')->comment('積分獎勵')->default(0);
            $table->decimal('total_spend', 10, 2)->comment('總支出')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crm_datas');
    }
}
