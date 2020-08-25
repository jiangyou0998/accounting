<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $fillable = ['menu_id', 'shop_group_id', 'price'];

    public function products()
    {
        return $this->belongsTo(TblOrderZMenu::class , "menu_id" , "id" );
    }

    public function shopGroup()
    {
        return $this->belongsTo(ShopGroup::class , "shop_group_id" , "id" );
    }
}
