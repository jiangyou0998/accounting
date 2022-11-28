<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class CustomerOrderCode extends Model
{

    protected $table = 'customer_order_codes';

    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(WorkshopProduct::class,"product_id","id");
    }

    public function shop_group()
    {
        return $this->belongsTo(ShopGroup::class,"shop_group_id","id");
    }

    public static function getCodes($shop_group_id)
    {
        $codes = self::query()
            ->with(['product'])
            //2022-11-28 產品有價錢 且 未暫停 才可以匹配
            ->whereHas('product', function ($query) use ($shop_group_id){
                $query->whereHas('prices',function ($query) use ($shop_group_id){
                    $query->where('shop_group_id', $shop_group_id);
                })->whereNotIn('status', [2, 4]);
            })
            ->where('shop_group_id', $shop_group_id)
            ->get();

        return $codes;
    }

}
