<?php

namespace App\Models;


use App\User;
use Illuminate\Database\Eloquent\Model;

class WarehouseStockItem extends Model
{

    protected $table = 'warehouse_stock_items';
    public $timestamps = false;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function product()
    {
        return $this->belongsTo(WarehouseProduct::class,'product_id','id');
    }

    public function unit()
    {
        return $this->belongsTo(WorkshopUnit::class,'unit_id','id');
    }

    public function scopeOfTimes($query, $times)
    {
        if ($times) {
            return $query->where('times', $times);
        }else{
            return $query->whereNull('times');
        }
    }

//    //獲取最大的Times
    public static function getMaxTimes($shop_id)
    {
        return self::query()
            ->where('user_id', $shop_id)
            ->max('times');
    }

}
