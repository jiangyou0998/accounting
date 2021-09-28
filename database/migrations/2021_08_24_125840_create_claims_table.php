<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClaimsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('claims', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id')->comment('員工ID');
            $table->integer('claim_level_id')->comment('索償等級ID');
            $table->integer('approver_id')->nullable()->comment('批准人ID');
            $table->integer('illness_id')->comment('病症ID');
            $table->decimal('cost', 10,2)->comment('實際金額');
            $table->decimal('claim_cost', 10,2)->comment('索償金額');
            $table->date('claim_date')->default(null)->nullable()->comment('診症日期');
            $table->integer('status')->default(0)->comment('0-申請中,1-已批核,2-不理賠');
            $table->string('file_path')->nullable()->comment('圖片位置');
            $table->timestamps();
        });

        Schema::table('claims', function ($table) {
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
        Schema::dropIfExists('claims');
    }
}
