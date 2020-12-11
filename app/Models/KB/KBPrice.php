<?php

namespace App\Models\KB;


use Illuminate\Database\Eloquent\Model;

class KBPrice extends Model
{
    protected $connection = 'mysql_kb';
    protected $table = 'prices';
    protected $fillable = ['product_id', 'shop_group_id', 'price'];

    public function products()
    {
        return $this->belongsTo(KBWorkshopProduct::class , "product_id" , "id" );
    }

    public function shopGroup()
    {
        return $this->belongsTo(ShopGroup::class , "shop_group_id" , "id" );
    }
}
