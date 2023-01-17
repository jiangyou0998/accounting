<?php

namespace App\Models\KB;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class KBWorkshopGroup extends Model
{
    //2022-03-17 當前網站默認的Group ID
    const CURRENTGROUPID = 4;

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

    //获取所有大類
    public static function getGroups()
    {
        $groups = new KBWorkshopGroup();
        $groups = $groups->with('cats')->whereHas('products', function (Builder $query) {
            $query->whereHas('prices', function (Builder $query) {
                $query->where('shop_group_id', '=', KBWorkshopGroup::CURRENTGROUPID);
            });
        })
            ->orderby('sort')
            ->get();

        $catAndGroup = [];
        foreach ($groups as $group){
            $catAndGroup[$group->cats->cat_name][$group->id] = $group->group_name;
        }

        return $catAndGroup;
    }

}
