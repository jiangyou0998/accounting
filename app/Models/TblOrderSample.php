<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TblOrderSample extends Model
{

    protected $table = 'tbl_order_sample';
    public $timestamps = false;

    //獲取固定柯打item
    public static function getRegularOrderItems($shop ,$dateofweek)
    {
        $items = new TblOrderSample();

        //設置select
        $items = $items
            ->select('tbl_order_z_menu.int_id as itemID')
            ->addSelect('tbl_order_z_menu.chr_name as itemName')
            ->addSelect('tbl_order_z_menu.chr_no')
            ->addSelect('tbl_order_z_unit.chr_name as UoM')
            ->addSelect('tbl_order_z_menu.chr_cuttime')
            ->addSelect('tbl_order_sample_item.qty as int_qty')
            ->addSelect('tbl_order_z_menu.int_phase')
            ->addSelect(DB::raw('LEFT(tbl_order_z_cat.chr_name, 2) AS suppName'))
            ->addSelect('tbl_order_z_menu.int_base')
            ->addSelect('tbl_order_z_menu.int_min')
            ->addSelect('tbl_order_z_menu.chr_canordertime');

        //設置關聯表
        $items = $items
            ->leftJoin('tbl_order_sample_item', 'tbl_order_sample_item.sample_id', '=', 'tbl_order_sample.id')
            ->leftJoin('tbl_order_z_menu', 'tbl_order_z_menu.int_id', '=', 'tbl_order_sample_item.menu_id')
            ->leftJoin('tbl_order_z_group', 'tbl_order_z_menu.int_group', '=', 'tbl_order_z_group.int_id')
            ->leftJoin('tbl_order_z_cat', 'tbl_order_z_group.int_cat', '=', 'tbl_order_z_cat.int_id')
            ->leftJoin('tbl_order_z_unit', 'tbl_order_z_menu.int_unit', '=', 'tbl_order_z_unit.int_id');

        //設置查詢條件
        $items = $items
            ->where('tbl_order_sample.user_id','=',$shop)
            ->where('tbl_order_sample.sampledate','like', "%$dateofweek%")
            ->where('tbl_order_sample_item.disabled','=',0)
            ->where('tbl_order_sample.disabled','=',0);

        $items = $items->orderBy('tbl_order_z_menu.chr_no')->get();

        return $items;

    }

}
