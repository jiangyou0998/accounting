<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class TblOrderZCat extends Model
{

    protected $table = 'tbl_order_z_cat';

    protected $primaryKey = 'int_id';

    public $timestamps = false;

    public function tblOrderZGroup()
    {
        return $this->hasMany(TblOrderZGroup::class,"int_cat","int_id");
    }

    public function tblOrderZMenu()
    {
        return $this->hasManyThrough(TblOrderZMenu::class,TblOrderZGroup::class,"int_id" ,"int_id","int_group","int_cat");
    }

    //查詢所有大類(除轉手貨)
    public static function getCatsExceptResale(){

        $cats = new TblOrderZCat();
        $cats = $cats->where('chr_name','<>', '轉手貨')
            ->orderby('int_sort')
            ->get(['int_id','chr_name']);

        return $cats;
    }

    //获取所有大類
    public static function getCats()
    {
        $cats = new TblOrderZCat();
        $cats = $cats
            ->orderby('int_sort')
            ->get();

        return $cats;
    }

    //获取所有大類(生效)
    public static function getCatsNotExpired($date)
    {
        $cats = new TblOrderZCat();
        $cats = $cats
            ->where(function ($query) use ($date){
                $query->whereNotNull('start_time')
                    ->whereDate('start_time','<=',$date);
            })->where(function ($query) use ($date){
                $query->whereNotNull('end_time')
                    ->whereDate('end_time','>=',$date);
            })->orWhere(function ($query) use ($date){
                $query->whereNull('start_time')
                    ->whereNull('end_time');
            })


            ->get();

        return $cats;
    }

}
