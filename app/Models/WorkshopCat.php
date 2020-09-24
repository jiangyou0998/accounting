<?php

namespace App\Models;

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
        return $this->hasManyThrough(WorkshopProduct::class,WorkshopGroup::class,"id" ,"id","group_id","cat_id");
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

    //获取所有大類(生效)
    public static function getCatsNotExpired($date)
    {
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
            })
            ->orderby('sort')
            ->get();

        return $cats;
    }


}
