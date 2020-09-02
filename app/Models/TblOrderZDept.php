<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TblOrderZDept extends Model
{

    protected $table = 'tbl_order_z_dept';

    protected $primaryKey = 'int_id';

    public $timestamps = false;

    public function users()
    {
        return $this->belongsTo(TblUser::class,'int_user','int_id');
    }

    public function products()
    {
        return $this->belongsTo(TblOrderZMenu::class,'int_product','int_id');
    }

    public static function getCartItems($shop , $dept , $advancePlusOne){


        $items = new TblOrderZDept();

        //設置select
        $items = $items
            ->select('tbl_order_z_dept.int_id as orderID')
            ->addSelect('tbl_order_z_menu.chr_name as itemName')
            ->addSelect('tbl_order_z_menu.chr_no')
            ->addSelect('tbl_order_z_unit.chr_name as UoM')
            ->addSelect('tbl_order_z_menu.chr_cuttime')
            ->addSelect('tbl_order_z_dept.int_qty')
            ->addSelect('tbl_order_z_dept.status')
            ->addSelect('tbl_order_z_menu.int_phase')
            ->addSelect(DB::raw('DATE(tbl_order_z_dept.order_date) as order_date'))
            ->addSelect(DB::raw('LEFT(tbl_order_z_cat.chr_name, 2) AS suppName'))
            ->addSelect('tbl_order_z_menu.int_id as itemID')
            ->addSelect('tbl_order_z_menu.int_base')
            ->addSelect('tbl_order_z_menu.int_min')
            ->addSelect('tbl_order_z_menu.chr_canordertime');

        //設置關聯表
        $items = $items
            ->leftJoin('tbl_order_z_menu', 'tbl_order_z_menu.int_id', '=', 'tbl_order_z_dept.int_product')
            ->leftJoin('tbl_order_z_group', 'tbl_order_z_menu.int_group', '=', 'tbl_order_z_group.int_id')
            ->leftJoin('tbl_order_z_cat', 'tbl_order_z_group.int_cat', '=', 'tbl_order_z_cat.int_id')
            ->leftJoin('tbl_order_z_unit', 'tbl_order_z_menu.int_unit', '=', 'tbl_order_z_unit.int_id');

        //設置查詢條件
        $items = $items
            ->where('tbl_order_z_dept.int_user','=',$shop)
            ->whereNotIn('tbl_order_z_dept.status',[4])
            ->where('tbl_order_z_dept.int_qty','>=',0)
            ->where('tbl_order_z_dept.chr_dept','=',$dept)
            ->whereRaw('DATE(DATE_ADD(tbl_order_z_dept.order_date, INTERVAL 1+chr_phase DAY)) = DATE(DATE_ADD(NOW(), INTERVAL ? DAY))',$advancePlusOne);

        $items = $items->orderBy('tbl_order_z_menu.chr_no')->get();

        return $items;

    }


}
