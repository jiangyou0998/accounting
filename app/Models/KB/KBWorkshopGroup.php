<?php

namespace App\Models\KB;


use Illuminate\Database\Eloquent\Model;

class KBWorkshopGroup extends Model
{
    //當前內聯網所屬商店分組ID
    const CURRENT_SHOP_ID = 5;

    protected $connection = 'mysql_kb';
    protected $table = 'workshop_groups';
    public $timestamps = false;

    public function cats()
    {
        return $this->belongsTo(KBWorkshopCat::class,"cat_id","id");
    }

    public function products()
    {
        return $this->hasMany(KBWorkshopProduct::class,"group_id","id");
    }

    //查詢所有轉手貨組
    public static function getResaleGroups(){

        $groups = new KBWorkshopGroup();
        $groups = $groups->where('cat_id', 5)
            ->get(['id','group_name']);

        return $groups;
    }

}
