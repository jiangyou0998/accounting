<?php

namespace App\Models;


use App\Models\Supplier\SupplierProduct;
use App\User;
use Illuminate\Database\Eloquent\Model;

class SupplierStockItem extends Model
{

    protected $table = 'supplier_stock_items';
    public $timestamps = false;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function product()
    {
        return $this->belongsTo(SupplierProduct::class,'product_id','id');
    }

}
