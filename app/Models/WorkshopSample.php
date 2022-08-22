<?php

namespace App\Models;


use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class WorkshopSample extends Model
{

    protected $table = 'workshop_order_sample';
    public $timestamps = false;

    public function scopeOfShopGroupId($query, $shop)
    {
        $shop_group_id = User::getShopGroupId($shop);
        if($shop_group_id){
            return $query->where('prices.shop_group_id','=',$shop_group_id);
        }else{
            throw new AccessDeniedHttpException('分店未加入分組,請聯繫管理員');
        }
    }

    //獲取固定柯打item
    public static function getRegularOrderItems($shop ,$dateofweek ,$dept = '')
    {
        $items = new WorkshopSample();

        //設置select
        $items = $items
            ->select('workshop_products.id as itemID')
            ->addSelect('workshop_order_sample_item.id as orderID')
            ->addSelect('workshop_products.product_name as itemName')
            ->addSelect('workshop_products.product_no')
            ->addSelect('workshop_units.unit_name as UoM')
            ->addSelect('workshop_order_sample_item.qty as qty')
            ->addSelect(DB::raw('LEFT(workshop_cats.cat_name, 2) AS suppName'))
            //2022-08-22 檢測分類為時節產品, 不跳星期日
            ->addSelect('workshop_cats.id as cat_id')
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
            ->whereNotIn('workshop_products.status', [2,4])
            //2021-03-17 獲取分組id
            ->ofShopGroupId($shop)
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
