<?php

namespace App\Models;


use App\User;
use Illuminate\Database\Eloquent\Model;

class StockItem extends Model
{

    protected $table = 'stock_items';
    public $timestamps = false;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function product()
    {
        return $this->belongsTo(WorkshopProduct::class,'product_id','id');
    }

}
