<?php

namespace App\Models;


use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class WorkshopCartItem extends Model
{

    protected $table = 'workshop_cart_items';
    const CREATED_AT = 'insert_date';
    const UPDATED_AT = 'order_date';

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

    public function scopeOfDept($query, $dept)
    {
        if(in_array($dept,config('dept.symbol'))){
            return $query->where('prices.shop_group_id','=',1);
        }else if($dept === 'RB'){
            return $query->where('prices.shop_group_id','=',5);
        }
    }

    public function scopeOfShopGroupId($query, $shop)
    {
        $shop_group_id = User::getShopGroupId($shop);
        if($shop_group_id){
            return $query->where('prices.shop_group_id','=',$shop_group_id);
        }else{
            throw new AccessDeniedHttpException('分店未加入分組,請聯繫管理員');
        }
    }

    public function scopeAddSelectAmount($query, $type = null)
    {
        $sql = '';
        switch ($type) {
            case 'CU':
                $sql = 'SUM(workshop_cart_items.qty) as qty_received';
                break;
            case 'CUR':
                $sql = 'SUM(ifnull(workshop_cart_items.qty_received, workshop_cart_items.qty) - workshop_cart_items.qty) as qty_received';
                break;
            default:
                $sql = 'SUM(ifnull(workshop_cart_items.qty_received, workshop_cart_items.qty)) as qty_received';
                break;
        }
        return $query->addSelect(DB::raw($sql));
    }

    public function scopeAddSelectTotal($query, $type = null)
    {
        switch ($type) {
            case 'CU':
                $sql = 'SUM(workshop_cart_items.qty * workshop_cart_items.order_price) as total';
                break;
            case 'CUR':
                $sql = 'SUM((workshop_cart_items.qty - ifnull(workshop_cart_items.qty_received, workshop_cart_items.qty)) * workshop_cart_items.order_price) as total';
                break;
            default:
                $sql = 'SUM(if(workshop_cart_items.qty_received is not null , workshop_cart_items.qty_received, workshop_cart_items.qty) * workshop_cart_items.order_price) as total';
                break;
        }
        return $query->addSelect(DB::raw($sql));
    }

    //外客R單不顯示數量為0的
    public function scopeHideZero($query, $type = null)
    {
        if($type == 'CUR'){
            $sql = 'workshop_cart_items.qty - ifnull(workshop_cart_items.qty_received, workshop_cart_items.qty) != 0';
            return $query->whereRaw($sql);
        }else{
            return $query;
        }
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
            //2021-01-15 根據dept選擇分組
//            ->ofDept($dept)
            ->ofShopGroupId($shop)
            ->where('workshop_cart_items.dept','=',$dept)
            ->where('workshop_cart_items.deli_date','=',$deli_date);

        $items = $items->orderBy('workshop_products.product_no')->get();

        return $items;

    }

    public static function getDeliDetail($deli_date, $shop , $type = null)
    {
        $items = new WorkshopCartItem();

        //設置select
        $items = $items
            ->addSelect('workshop_products.product_name as itemName')
            ->addSelect('workshop_products.product_no')
            ->addSelect('workshop_units.unit_name as UoM')
            ->addSelect(DB::raw('SUM(workshop_cart_items.qty) as qty'))
//            ->addSelect(DB::raw('SUM(ifnull(workshop_cart_items.qty_received, workshop_cart_items.qty)) as qty_received'))
            ->addSelectAmount($type)
            //2020-11-23 workshop_products.default_price改為workshop_cart_items.order_price
            ->addSelect(DB::raw('MAX(workshop_cart_items.order_price) as default_price'))
            ->addSelect('workshop_cats.id as cat_id')
            ->addSelect('workshop_cats.cat_name')
            ->addSelect('workshop_products.id as itemID');

        //2021-01-13 把糧友也查詢進去
        foreach (config('dept.symbol_all') as $dept) {
            $sql = "ROUND(sum(case when workshop_cart_items.dept = '$dept' then workshop_cart_items.qty else 0 end),2) as '".$dept."_total'";
            $items = $items
                ->addSelect(DB::raw($sql));
        }

        foreach (config('dept.symbol_all') as $dept) {
            $sql = "ROUND(sum(case when workshop_cart_items.dept = '$dept' then (ifnull(workshop_cart_items.qty_received,workshop_cart_items.qty)) else 0 end),2) as '".$dept."_total_received'";
            $items = $items
                ->addSelect(DB::raw($sql));
        }

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
            ->where('workshop_cart_items.deli_date','=',$deli_date)
            ->hideZero($type);

        $items = $items
            ->groupBy('workshop_products.id')
            ->orderBy('workshop_products.product_no')
            ->get();

        return $items;

    }

    public static function getDeliTotal($deli_date, $shop, $type = null)
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
            ->addSelectTotal($type);


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

    public static function getDeliLists($deli_date, $group){

        $items = new WorkshopCartItem();

        //設置select
        $items = $items
            ->select('deli_date')
            ->addSelect('users.report_name')
            ->addSelect('workshop_cart_items.user_id')
            ->addSelect(DB::raw('SUM(order_price * ifnull(qty_received,qty)) as po_total'))
        ;

        //設置關聯表
        $items = $items
            ->leftJoin('workshop_products', 'workshop_products.id', '=', 'workshop_cart_items.product_id')
            ->leftJoin('users', 'users.id', '=', 'workshop_cart_items.user_id');

        //設置查詢條件
        $items = $items
            ->whereNotIn('workshop_cart_items.status',[4])
            ->where('workshop_cart_items.deli_date','=',$deli_date);

        switch ($group){
            case 'KB' :
                $items = $items
                    //2021-01-06 不顯示KB以外的
                    ->whereIn('workshop_cart_items.dept', config('dept.symbol'));
                break;

            case 'RB' :
                $items = $items
                    //2021-01-06 不顯示KB以外的
                    ->where('workshop_cart_items.dept', 'RB');
                break;

            case 'CU' :
                $items = $items
                    ->where('workshop_cart_items.dept', 'CU');
                break;

        }

        $items = $items
            ->groupBy('workshop_cart_items.deli_date','workshop_cart_items.user_id')
            ->orderBy('workshop_cart_items.deli_date')->get();

        return $items;

    }

    //
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
