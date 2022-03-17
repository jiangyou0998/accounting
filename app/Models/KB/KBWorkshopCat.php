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

    //获取所有大類
    public static function getSampleCats($dept)
    {
        $cats = new KBWorkshopCat();

        //A第一車,B第二車,C麵頭,D方包
        if($dept == 'A' || $dept == 'B'){
            $cats = $cats->whereIn('cat_name',['熟細包','熟大包']);
        }else if($dept == 'C'){
            $cats = $cats->whereIn('cat_name',['麵頭']);
        }else if($dept == 'D'){
            $cats = $cats->whereIn('cat_name',['方包']);
        }

        $cats = $cats
            ->orderby('sort')
            ->get();

        return $cats;
    }

    //获取所有大類(生效)
    public static function getCatsNotExpired($date , $dept)
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

        //2020-12-10 只查詢有糧友商品價格的大類
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
