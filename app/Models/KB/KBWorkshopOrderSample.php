<?php

namespace App\Models\KB;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class KBWorkshopOrderSample extends Model
{
    protected $connection = 'mysql_kb';
    protected $table = 'workshop_order_sample';
    public $timestamps = false;

    public static function getSampleByDept($dept)
    {
        $sampleModel = self::query();

        $samples = $sampleModel
            ->addSelect('workshop_order_sample.user_id')
            ->addSelect('workshop_order_sample.sampledate')
            ->addSelect('workshop_order_sample.dept')
            ->addSelect('workshop_order_sample_item.product_id')
            ->addSelect('workshop_order_sample_item.qty');

        $samples = $samples
            ->leftJoin('workshop_order_sample_item','workshop_order_sample_item.sample_id','=','workshop_order_sample.id');

        $samples = $samples
            ->where('workshop_order_sample.dept' , $dept)
            ->where('workshop_order_sample.disabled',0)
            ->where('workshop_order_sample_item.disabled',0);

        $samples = $samples->get();

        return $samples;

    }

    //獲取固定柯打item
    public static function getRegularOrderItems($shop ,$dateofweek ,$dept = '')
    {
        $items = self::query();

        //設置select
        $items = $items
            ->select('workshop_products.id as itemID')
            ->addSelect('workshop_order_sample_item.id as orderID')
            ->addSelect('workshop_products.product_name as itemName')
            ->addSelect('workshop_products.product_no')
            ->addSelect('workshop_units.unit_name as UoM')
            ->addSelect('workshop_order_sample_item.qty as qty')
            ->addSelect(DB::raw('LEFT(workshop_cats.cat_name, 2) AS suppName'))
            //2021-01-06 獲取prices表cuttime,phase,base,min,canordertime
            ->addSelect('prices.cuttime')
            ->addSelect('prices.phase')
            ->addSelect('prices.base')
            ->addSelect('prices.min')
            ->addSelect('prices.canordertime');

        //設置關聯表
        $items = $items
            ->leftJoin('workshop_order_sample_item', 'workshop_order_sample_item.sample_id', '=', 'workshop_order_sample.id')
            ->leftJoin('workshop_products', 'workshop_products.id', '=', 'workshop_order_sample_item.product_id')
            ->leftJoin('workshop_groups', 'workshop_products.group_id', '=', 'workshop_groups.id')
            ->leftJoin('workshop_cats', 'workshop_groups.cat_id', '=', 'workshop_cats.id')
            ->leftJoin('workshop_units', 'workshop_products.unit_id', '=', 'workshop_units.id')
            //2021-01-06 關聯價格表
            ->leftJoin('prices', 'workshop_order_sample_item.product_id','=','prices.product_id');

        //設置查詢條件
        $items = $items
            ->where('workshop_order_sample.user_id','=',$shop)
//            ->where('workshop_order_sample.dept','=',$dept)
            ->where('workshop_order_sample.sampledate','like', "%$dateofweek%")
            //20.10.22 判斷範本產品是否已暫停
            ->where('workshop_products.status','!=',2)
            //2022-03-17 貳號分組為4
            ->where('prices.shop_group_id', '=' , KBWorkshopGroup::CURRENTGROUPID)
            ->where('workshop_order_sample_item.disabled','=',0)
            ->where('workshop_order_sample.disabled','=',0);

        if($dept){
            $items = $items->where('workshop_order_sample.dept','=',$dept);
        }

        $items = $items->orderBy('workshop_products.product_no')->get();

//        dump($items);

        return $items;

    }

}
