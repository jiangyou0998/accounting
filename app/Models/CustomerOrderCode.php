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

    public static function getCodes($shop_group_id)
    {
        $codes = self::query()
            ->with(['product'])
            ->where('shop_group_id', $shop_group_id)
            ->get();

        return $codes;
    }

}
