<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',20)->comment('員工名稱');
            $table->string('code',20)->unique()->comment('員工編號');
            $table->integer('claim_level')->comment('索償等級(一對多)');
            $table->boolean('is_worked')->default(1)->comment('0-離職,1-在職');
            $table->date('leave_date')->default(null)->nullable()->comment('離職日期');
            $table->timestamps();
        });

        Schema::table('employees', function ($table) {
            $table->dateTime('created_at')->change();
            $table->dateTime('updated_at')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
