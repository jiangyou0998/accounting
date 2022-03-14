<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class WorkshopGroup extends Model
{

    protected $table = 'workshop_groups';
    public $timestamps = false;

    public function cats()
    {
        return $this->belongsTo(WorkshopCat::class,"cat_id","id");
    }

    public function products()
    {
        return $this->hasMany(WorkshopProduct::class,"group_id","id");
    }

    //查詢所有轉手貨組
//    public static function getResaleGroups(){
//
//        $groups = new WorkshopGroup();
//        $groups = $groups->where('cat_id', 5)
//            ->get(['id','group_name']);
//
//        return $groups;
//    }

}
