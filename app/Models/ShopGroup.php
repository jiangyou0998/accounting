<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ShopGroup extends Model
{

    protected $table = 'shop_groups';

    public function price()
    {
        return $this->hasMany(Price::class,"shop_group_id" , "id");
    }


}
