<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFrontGroupHasUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('front_group_has_users', function (Blueprint $table) {
            $table->unsignedBigInteger('front_group_id');
            $table->unsignedBigInteger('user_id');

            $table->foreign('front_group_id')
                ->references('id')
                ->on('front_groups')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->primary(['front_group_id', 'user_id'], 'front_group_has_users_front_group_id_user_id_primary');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('front_group_has_users');
    }
}
