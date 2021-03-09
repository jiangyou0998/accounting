<?php

namespace App\Models;


use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class WorkshopCartItem extends Model
{

    protected $table = 'workshop_cart_items';
    public $timestamps = false;

    protected $guarded = [];

    public function users()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function products()
    {
        return $this->belongsTo(WorkshopProduct::class,'product_id','id');
    }

    public function cart_item_logs()
    {
        return $this->hasMany(WorkshopCartItemLog::class,"cart_item_id","id");
    }

    public function scopeOfShop($query, $shop)
    {
        if($shop === 'kb'){
            return $query->where('users.name','like', 'kb%')
                ->orWhere('users.name','like','ces%')
                ->orWhere('users.name','like','b&b%');
        }else if($shop === 'rb'){
            return $query->where('users.name','like', 'rb%');
        }
    }

    //2021-02-03 type=1,一車 type=2,二車 type=0,全部
    public function scopeOfType($query, $type = 0)
    {
        switch ($type){
            case 0:
                $query = $query;
                break;
            case 1:
                $query = $query->where('workshop_cart_items.dept','!=', 'B');
                break;
            case 2:
                $query = $query->where('workshop_cart_items.dept','=', 'B');
                break;
        }

        return $query;
    }

    public static function getCartItems($shop , $dept , $deli_date){


        $items = new WorkshopCartItem();

        //設置select
        $items = $items
            ->select('workshop_cart_items.id as orderID')
            ->addSelect('workshop_products.product_name as itemName')
            ->addSelect('workshop_products.product_no')
            ->addSelect('workshop_units.unit_name as UoM')
            ->addSelect('workshop_cart_items.qty')
            ->addSelect('workshop_cart_items.status')
            ->addSelect(DB::raw('DATE(workshop_cart_items.order_date) as order_date'))
            ->addSelect(DB::raw('LEFT(workshop_cats.cat_name, 2) AS suppName'))
            ->addSelect('workshop_products.id as itemID')
            //2021-01-06 獲取prices表cuttime,phase,base,min,canordertime
            ->addSelect('prices.cuttime')
            ->addSelect('prices.phase')
            ->addSelect('prices.base')
            ->addSelect('prices.min')
            ->addSelect('prices.canordertime');

        //設置關聯表
        $items = $items
            ->leftJoin('workshop_products', 'workshop_products.id', '=', 'workshop_cart_items.product_id')
            ->leftJoin('workshop_groups', 'workshop_products.group_id', '=', 'workshop_groups.id')
            ->leftJoin('workshop_cats', 'workshop_groups.cat_id', '=', 'workshop_cats.id')
            ->leftJoin('workshop_units', 'workshop_products.unit_id', '=', 'workshop_units.id')
            //2021-01-06 關聯價格表
            ->leftJoin('prices', 'workshop_cart_items.product_id','=','prices.product_id');

        //設置查詢條件
        $items = $items
            ->where('workshop_cart_items.user_id','=',$shop)
            ->whereNotIn('workshop_cart_items.status',[4])
            ->where('workshop_cart_items.qty','>=',0)
            //2021-01-06 糧友分組為5
            ->where('prices.shop_group_id','=',5)
            ->where('workshop_cart_items.dept','=',$dept)
            ->where('workshop_cart_items.deli_date','=',$deli_date);

        $items = $items->orderBy('workshop_products.product_no')->get();

        return $items;

    }

    public static function getDeliDetail($deli_date, $shop)
    {
        $items = new WorkshopCartItem();

        //設置select
        $items = $items
            ->addSelect('workshop_products.product_name as itemName')
            ->addSelect('workshop_products.product_no')
            ->addSelect('workshop_units.unit_name as UoM')
            ->addSelect(DB::raw('SUM(workshop_cart_items.qty) as qty'))
            ->addSelect(DB::raw('SUM(ifnull(workshop_cart_items.qty_received, workshop_cart_items.qty)) as qty_received'))
            //2020-11-23 workshop_products.default_price改為workshop_cart_items.order_price
            ->addSelect(DB::raw('SUM(workshop_cart_items.order_price) as default_price'))
            ->addSelect('workshop_cats.id as cat_id')
            ->addSelect('workshop_cats.cat_name')
            ->addSelect('workshop_products.id as itemID');

        foreach (config('dept.symbol') as $dept) {
            $sql = "ROUND(sum(case when workshop_cart_items.dept = '$dept' then workshop_cart_items.qty else 0 end),2) as '".$dept."_total'";
            $items = $items
                ->addSelect(DB::raw($sql));
        }

        foreach (config('dept.symbol') as $dept) {
            $sql = "ROUND(sum(case when workshop_cart_items.dept = '$dept' then (ifnull(workshop_cart_items.qty_received,workshop_cart_items.qty)) else 0 end),2) as '".$dept."_total_received'";
            $items = $items
                ->addSelect(DB::raw($sql));
        }

        //todo
        //foreach ABC聚合試試

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
            ->where('workshop_cart_items.deli_date','=',$deli_date);

        $items = $items
            ->groupBy('workshop_products.id')
            ->orderBy('workshop_products.product_no')->get();

        return $items;

    }

    public static function getDeliTotal($deli_date, $shop)
    {
        $items = new WorkshopCartItem();

        //設置select
        $items = $items
            ->select('workshop_cats.id as cat_id')
            ->addSelect('workshop_cats.cat_name')
            //計算總數量
            ->addSelect(DB::raw('SUM(if(workshop_cart_items.qty_received is not null , workshop_cart_items.qty_received, workshop_cart_items.qty)) as qty_total'))
            //計算總價
            //2020-11-23 workshop_products.default_price改為workshop_cart_items.order_price
            ->addSelect(DB::raw('SUM(if(workshop_cart_items.qty_received is not null , workshop_cart_items.qty_received, workshop_cart_items.qty) * workshop_cart_items.order_price) as total'));

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
            ->where('workshop_cart_items.deli_date','=',$deli_date);

        $items = $items->groupBy('workshop_cats.id')
            ->orderBy('workshop_cats.sort')
            ->get();

        return $items;
    }

    public static function getDeliItem($deli_date, $shop)
    {
        $items = new WorkshopCartItem();

        //設置select
        $items = $items
            ->select('workshop_cart_items.id as orderID')
            ->addSelect('workshop_cart_items.deli_date')
            ->addSelect('workshop_cart_items.user_id')
            ->addSelect('workshop_cart_items.product_id')
            ->addSelect(DB::raw('ROUND(workshop_cart_items.qty,0) as dept_qty'))
            ->addSelect('workshop_cart_items.dept')
            //2020-11-23 workshop_products.default_price改為workshop_cart_items.order_price
            ->addSelect('workshop_cart_items.order_price as default_price' )
            ->addSelect('workshop_units.unit_name as UoM')
            ->addSelect(DB::raw('ROUND(ifnull(workshop_cart_items.qty_received , workshop_cart_items.qty),0) as qty_received'))
            ->addSelect('workshop_cats.id as cat_id')
            ->addSelect('workshop_cart_items.reason')
            ->addSelect('workshop_cats.cat_name')
            ->addSelect('workshop_products.product_name as item_name')
            ->addSelect('workshop_products.id as itemID');

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
            ->where('workshop_cart_items.deli_date','=',$deli_date);

        $items = $items->orderBy('workshop_products.product_no')->get();

        return $items;

    }

    public static function getDeliLists($deli_date){

        $items = new WorkshopCartItem();

        //設置select
        $items = $items
            ->select('deli_date')
            ->addSelect('users.report_name')
            ->addSelect('workshop_cart_items.user_id')
            ->addSelect(DB::raw('SUM(prices.price * ifnull(qty_received,qty)) as po_total'))
        ;

        //設置關聯表
        $items = $items
            ->leftJoin('workshop_products', 'workshop_products.id', '=', 'workshop_cart_items.product_id')
            ->leftJoin('users', 'users.id', '=', 'workshop_cart_items.user_id')
            //2021-01-06 價格從price表拿
            ->leftJoin('prices', 'workshop_products.id', '=', 'prices.product_id');

        //設置查詢條件
        $items = $items
            ->whereNotIn('workshop_cart_items.status',[4])
            //2021-01-06 價格從price表拿
            ->where('prices.shop_group_id','=',5)
            //2021-01-06 不顯示symbol以外的
            ->whereIn('workshop_cart_items.dept', config('dept.symbol'))
            ->where('workshop_cart_items.deli_date','=',$deli_date);

        $items = $items
            ->groupBy('workshop_cart_items.deli_date','workshop_cart_items.user_id')
            ->orderBy('workshop_cart_items.deli_date')->get();

        return $items;

    }

    public static function getRegularOrderCount($shopids , $start_date ,$end_date ,$dept)
    {
        $items = new WorkshopCartItem();

        //設置select
        $items = $items
            ->addSelect('workshop_cart_items.deli_date')
            ->addSelect('workshop_cart_items.user_id')
            ->addSelect(DB::raw('count(*) as count'))
        ;

        //設置關聯表
//        $items = $items
//            ->leftJoin('workshop_products', 'workshop_products.id', '=', 'workshop_cart_items.product_id')
//            ->leftJoin('workshop_groups', 'workshop_products.group_id', '=', 'workshop_groups.id')
//            ->leftJoin('workshop_cats', 'workshop_groups.cat_id', '=', 'workshop_cats.id')
//            ->leftJoin('workshop_units', 'workshop_products.unit_id', '=', 'workshop_units.id');

        //設置查詢條件
        $items = $items
            ->whereIn('workshop_cart_items.user_id',$shopids)
            ->whereNotIn('workshop_cart_items.status',[4])
            ->where('workshop_cart_items.qty','>=',0)
            ->where('workshop_cart_items.deli_date','>=',$start_date)
            ->where('workshop_cart_items.deli_date','<=',$end_date)
        ;

        if($dept){
            $items = $items->where('workshop_cart_items.dept', $dept);
        }

        $items = $items
            ->groupBy('workshop_cart_items.deli_date')
            ->groupBy('workshop_cart_items.user_id')
        ;

        $items = $items
//            ->orderBy('workshop_products.product_no')
            ->get();

        return $items;

    }




}
