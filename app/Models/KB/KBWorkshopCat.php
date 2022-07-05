<?php

namespace App\Models\KB;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class KBWorkshopCat extends Model
{
    protected $connection = 'mysql_kb';
    protected $table = 'workshop_cats';
    public $timestamps = false;

    public function groups()
    {
        return $this->hasMany(KBWorkshopGroup::class,"cat_id","id");
    }

    public function products()
    {
        return $this->hasManyThrough(
            KBWorkshopProduct::class,
            KBWorkshopGroup::class,
            "cat_id" ,
            "group_id",
            "id",
            "id");
    }

    //查詢所有大類(除轉手貨)
    public static function getCatsExceptResale(){

        $cats = new KBWorkshopCat();
        $cats = $cats->where('cat_name','!=', '轉手貨')
            ->orderby('sort')
            ->get(['id','cat_name']);

        return $cats;
    }

    //获取所有大類
    public static function getCats()
    {
        $cats = new KBWorkshopCat();
        $cats = $cats
            ->orderby('sort')
            ->get();

        return $cats;
    }

    //範本-根據type获取所有大類
    public static function getSampleCats($type)
    {
        $cats = new KBWorkshopCat();

        //bakery-包部,kitchen-廚房,waterbar-水吧
        if($type == 'bakery'){
            $cats = $cats->whereIn('cat_name',['麵包部', '西餅部', '轉手貨']);
        }else if($type == 'kitchen'){
            $cats = $cats->whereIn('cat_name',['廚務部', '轉手貨']);
        }else if($type == 'waterbar'){
            $cats = $cats->whereIn('cat_name',['麵包部', '廚務部', '轉手貨']);
        }

        $cats = $cats
            ->orderby('sort')
            ->get();

        return $cats;
    }

    //获取所有大類(生效)
    public static function getCatsNotExpired($date , $type)
    {
        $cats = new KBWorkshopCat();
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
            });

        //2022-04-25 bakery-包部,kitchen-廚房,waterbar-水吧
        //不顯示跟部門無關分類
        if($type == 'bakery'){
            $cats = $cats->whereNotIn('cat_name',['廚務部']);
        }else if($type == 'kitchen'){
            $cats = $cats->whereNotIn('cat_name',['麵包部', '西餅部']);
        }else if($type == 'waterbar'){
            $cats = $cats->whereNotIn('cat_name',['西餅部']);
        }

        //2022-03-25 只查詢有商品價格的大類
        $cats = $cats->whereHas('products', function (Builder $query) {
                 $query->whereHas('prices', function (Builder $query) {
                     $query->where('shop_group_id', '=', KBWorkshopGroup::CURRENTGROUPID);
                 });
             })
            ->orderby('sort')
            ->get();

        return $cats;
    }


}
