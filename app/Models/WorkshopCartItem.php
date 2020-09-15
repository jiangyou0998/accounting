<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class WorkshopCartItem extends Model
{

    protected $table = 'workshop_cart_items';
    public $timestamps = false;

    public static function getCartItems($shop , $dept , $deli_date){


        $items = new WorkshopCartItem();

        //設置select
        $items = $items
            ->select('workshop_cart_items.id as orderID')
            ->addSelect('workshop_products.product_name as itemName')
            ->addSelect('workshop_products.product_no')
            ->addSelect('workshop_units.unit_name as UoM')
            ->addSelect('workshop_products.cuttime')
            ->addSelect('workshop_cart_items.qty')
            ->addSelect('workshop_cart_items.status')
            ->addSelect('workshop_products.phase')
            ->addSelect(DB::raw('DATE(workshop_cart_items.order_date) as order_date'))
            ->addSelect(DB::raw('LEFT(workshop_cats.cat_name, 2) AS suppName'))
            ->addSelect('workshop_products.id as itemID')
            ->addSelect('workshop_products.base')
            ->addSelect('workshop_products.min')
            ->addSelect('workshop_products.canordertime');

        //設置關聯表
        $items = $items
            ->leftJoin('workshop_products', 'workshop_products.id', '=', 'workshop_cart_items.product_id')
            ->leftJoin('workshop_groups', 'workshop_products.group_id', '=', 'workshop_groups.id')
            ->leftJoin('workshop_cats', 'workshop_groups.cat_id', '=', 'workshop_cats.id')
            ->leftJoin('workshop_units', 'workshop_products.unit_id', '=', 'workshop_units.id');

        //設置查詢條件
        $items = $items
            ->where('workshop_cart_items.user_id','=',$shop)
            ->whereNotIn('workshop_cart_items.status',[4])
            ->where('workshop_cart_items.qty','>=',0)
            ->where('workshop_cart_items.dept','=',$dept)
            ->where('workshop_cart_items.deli_date','=',$deli_date);

        $items = $items->orderBy('workshop_products.product_no')->get();

        return $items;

    }

}
