<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCanViewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('front_user_can_views', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');

            $table->string('model_type');
            $table->unsignedBigInteger('model_id');
            $table->index(['model_id', 'model_type'], 'front_user_can_view_model_id_model_type_index');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->primary(['user_id', 'model_id', 'model_type'],
                'front_user_can_view_role_model_type_primary');});

        Schema::create('front_groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->default('');
            $table->unsignedInteger('sort');
            $table->timestamps();
        });

        Schema::create('front_group_can_views', function (Blueprint $table) {
            $table->unsignedBigInteger('group_id');

            $table->string('model_type');
            $table->unsignedBigInteger('model_id');
            $table->index(['model_id', 'model_type'], 'front_group_can_view_model_id_model_type_index');

            $table->foreign('group_id')
                ->references('id')
                ->on('front_groups')
                ->onDelete('cascade');

            $table->primary(['group_id', 'model_id', 'model_type'],
                'front_group_can_view_role_model_type_primary');});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('can_view');
    }
}
