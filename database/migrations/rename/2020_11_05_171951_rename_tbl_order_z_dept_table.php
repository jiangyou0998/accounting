<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameTblOrderZDeptTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_order_z_dept', function (Blueprint $table) {
            Schema::rename('tbl_order_z_dept', 'workshop_cart_items');
//            $table->date('deli_date')->default(null);
        });

        Schema::table('workshop_cart_items', function (Blueprint $table) {
            $table->renameColumn('int_id','id');
            $table->renameColumn('int_user','user_id');
            $table->renameColumn('int_product','product_id');
            $table->renameColumn('int_qty','qty');
            $table->renameColumn('chr_ip','ip');
            $table->renameColumn('chr_po_no','po_no');
            $table->renameColumn('chr_dept','dept');
            $table->renameColumn('int_qty_received','qty_received');
            $table->date('deli_date')->nullable()->default(null);
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
