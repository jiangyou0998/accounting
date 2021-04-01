<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class WorkshopCat extends Model
{

    protected $table = 'workshop_cats';
    public $timestamps = false;

    public function groups()
    {
        return $this->hasMany(WorkshopGroup::class,"cat_id","id");
    }

    public function products()
    {
        return $this->hasManyThrough(WorkshopProduct::class,WorkshopGroup::class,"cat_id" ,"group_id","id","id");
    }

    //查詢所有大類(除轉手貨)
    public static function getCatsExceptResale(){

        $cats = new WorkshopCat();
        $cats = $cats->where('cat_name','!=', '轉手貨')
            ->orderby('sort')
            ->get(['id','cat_name']);

        return $cats;
    }

    //获取所有大類
    public static function getCats()
    {
        $cats = new WorkshopCat();
        $cats = $cats
            ->orderby('sort')
            ->get();

        return $cats;
    }

    //获取所有大類
    public static function getSampleCats($dept)
    {
        $cats = new WorkshopCat();

        //A第一車,B第二車,C麵頭,D方包
//        if($dept == 'A' || $dept == 'B'){
//            $cats = $cats->whereIn('cat_name',['熟細包','熟大包']);
//        }else if($dept == 'C'){
//            $cats = $cats->whereIn('cat_name',['麵頭']);
//        }else if($dept == 'D'){
//            $cats = $cats->whereIn('cat_name',['方包']);
//        }

        $cats = $cats
            ->whereNotIn('cat_name',['時節產品'])
            ->orderby('sort')
            ->get();

        return $cats;
    }

    //获取所有大類(生效)
    public static function getCatsNotExpired($date , $shopid)
    {
        $shop_group_id = User::getShopGroupId($shopid);
        $cats = new WorkshopCat();

        $cats = $cats
            ->where(function ($query) use ($date){
                $query->whereNotNull('start_date')
                    ->whereDate('start_date','<=',$date);
            })->where(function ($query) use ($date){
                $query->whereNotNull('end_date')
                    ->whereDate('end_date','>=',$date);
            })->orWhere(function ($query) use ($date){
                $query->whereNull('start_date')
                    ->whereNull('end_date');
            })->whereHas('products', function ($query) use ($shop_group_id){
                $query->whereHas('prices',function ($query) use ($shop_group_id){
                    $query->where('shop_group_id',$shop_group_id);
                });
            });

        $cats = $cats
            ->orderby('sort')
            ->get();

        return $cats;
    }


}
