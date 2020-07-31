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

}
