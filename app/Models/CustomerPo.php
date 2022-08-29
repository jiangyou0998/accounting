<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class CustomerPo extends Model
{

    protected $table = 'customer_pos';

    public $timestamps = false;

    public function scopeOfShopIds($query, $shop_ids){
        if($shop_ids){
            $shopIdArr = explode("-", $shop_ids);
            return $query->whereIn('shop_id', $shopIdArr);
        }else{
            return $query;
        }
    }

}
