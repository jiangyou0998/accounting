<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $guarded = [];

    public function products()
    {
        return $this->belongsTo(WorkshopProduct::class , "product_id" , "id" )->with(['groups', 'cats']);
    }

    public function shopGroup()
    {
        return $this->belongsTo(ShopGroup::class , "shop_group_id" , "id" );
    }

    //2020-12-31 使用修改器將canordertime修改成字符串
    public function setCanordertimeAttribute($value)
    {
        if(is_array($value)){
            $this->attributes['canordertime'] = implode(",", array_filter($value, function ($var) {
                //array_filter不去掉0
                return ($var === '' || $var === null || $var === false) ? false : true;
            }));
        }else{
            $this->attributes['canordertime'] = $value;
        }
    }

    public static function getProductPriceByShopGroup($shop_group_id){
        $prices = WorkshopProduct::with('prices')->whereHas('prices', function (Builder $query) use($shop_group_id){
            $query->where('shop_group_id', '=', $shop_group_id);
        })->get()->mapWithKeys(function ($item) use($shop_group_id){
            $price = $item['prices']->where('shop_group_id', $shop_group_id)->first()->price;
            return [$item['id'] => $price ];
        });

        return $prices;
    }

}
