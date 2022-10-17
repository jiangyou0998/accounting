<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class WarehouseProductPrice extends Model
{

    protected $table = 'warehouse_product_prices';

    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(WarehouseProduct::class , "product_id" , "id" );
    }

    public function scopeIsEndDate9999($query, $end_date)
    {
        if ('9999-12-31' === $end_date){
            return $query->whereDate('end_date', '<', '9999-12-31');
        }else{
            return $query;
        }
    }

    public function scopeHasPrice($query, $start_date, $end_date)
    {
        if ($start_date && $end_date) {
            return $query->where(function($query) use($start_date){
                $query->where('start_date', '<=', $start_date)
                    ->where('end_date', '>=', $start_date);
            })->orWhere(function($query) use($end_date){
                $query->where('start_date', '<=', $end_date)
                    ->where('end_date', '>=', $end_date);
            });
        }else{
            return $query;
        }
    }

}
