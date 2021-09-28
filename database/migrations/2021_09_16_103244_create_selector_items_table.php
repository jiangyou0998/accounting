<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSelectorItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('selector_items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type_name')->comment('item類型');
            $table->unsignedInteger('sort')->comment('排序');
            $table->string('item_name')->comment('選擇item名稱');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('selector_items');
    }
}
