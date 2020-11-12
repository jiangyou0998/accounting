<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopGroupHasUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_group_has_users', function (Blueprint $table) {
            $table->unsignedBigInteger('shop_group_id');
            $table->unsignedBigInteger('user_id');

            $table->foreign('shop_group_id')
                ->references('id')
                ->on('shop_groups')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->primary(['shop_group_id', 'user_id'], 'shop_group_has_users_shop_group_id_user_id_primary');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_group_has_users');
    }
}
