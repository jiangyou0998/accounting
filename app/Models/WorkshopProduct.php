<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class WorkshopProduct extends Model
{

    protected $table = 'workshop_products';

    public function groups()
    {
        return $this->belongsTo(WorkshopGroup::class,"group_id","id");
    }

    public function cats()
    {
        return $this->hasOneThrough(WorkshopCat::class,WorkshopGroup::class,"id" ,"id","group_id","cat_id");
    }

    public function units()
    {
        return $this->belongsTo(WorkshopUnit::class,"unit_id","id");
    }

//    public function tblUser(): BelongsToMany
//    {
//        $pivotTable = 'tbl_order_z_menu_v_shop'; // 中间表
//
//        $relatedModel = tblUser::class; // 关联模型类名
//
//        return $this->belongsToMany($relatedModel, $pivotTable, 'int_user_id', 'int_menu_id');
//    }

    public function price()
    {
        return $this->hasMany(Price::class,"menu_id","id");
    }


}
