<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class WorkshopSample extends Model
{

    protected $table = 'workshop_order_sample';
    public $timestamps = false;

    //獲取固定柯打item
    public static function getRegularOrderItems($shop ,$dateofweek)
    {
        $items = new WorkshopSample();

        //設置select
        $items = $items
            ->select('workshop_products.id as itemID')
            ->addSelect('workshop_products.product_name as itemName')
            ->addSelect('workshop_products.product_no')
            ->addSelect('workshop_units.unit_name as UoM')
            ->addSelect('workshop_products.cuttime')
            ->addSelect('workshop_order_sample_item.qty as qty')
            ->addSelect('workshop_products.phase')
            ->addSelect(DB::raw('LEFT(workshop_cats.cat_name, 2) AS suppName'))
            ->addSelect('workshop_products.base')
            ->addSelect('workshop_products.min')
            ->addSelect('workshop_products.canordertime');

        //設置關聯表
        $items = $items
            ->leftJoin('workshop_order_sample_item', 'workshop_order_sample_item.sample_id', '=', 'workshop_order_sample.id')
            ->leftJoin('workshop_products', 'workshop_products.id', '=', 'workshop_order_sample_item.product_id')
            ->leftJoin('workshop_groups', 'workshop_products.group_id', '=', 'workshop_groups.id')
            ->leftJoin('workshop_cats', 'workshop_groups.cat_id', '=', 'workshop_cats.id')
            ->leftJoin('workshop_units', 'workshop_products.unit_id', '=', 'workshop_units.id');

        //設置查詢條件
        $items = $items
            ->where('workshop_order_sample.user_id','=',$shop)
            ->where('workshop_order_sample.sampledate','like', "%$dateofweek%")
            ->where('workshop_order_sample_item.disabled','=',0)
            ->where('workshop_order_sample.disabled','=',0);

        $items = $items->orderBy('workshop_products.product_no')->get();

//        dump($items);

        return $items;

    }

}
