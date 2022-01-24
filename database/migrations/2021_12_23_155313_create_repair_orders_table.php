<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepairOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repair_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->comment('分店ID');
            $table->string('order_no', 20)->comment('維修單編號');
            $table->date('complete_date')->comment('完成時間');
            $table->string('finished_start_time', 10)->comment('到店時間');
            $table->string('finished_end_time', 10)->comment('離開時間');
            $table->string('handle_staff', 20)->comment('維修員');
            $table->decimal('fee', 10, 2)->comment('維修費用');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('repair_orders');
    }
}
