<?php

namespace App\Models;


use App\User;
use Illuminate\Database\Eloquent\Model;

class WorkshopCartItemLog extends Model
{

    protected $table = 'workshop_cart_item_logs';

    protected $guarded = [];

    public function operate_users()
    {
        return $this->belongsTo(User::class,"operate_user_id","id");
    }

    public function shops()
    {
        return $this->belongsTo(User::class,"shop_id","id");
    }

    public function products()
    {
        return $this->belongsTo(WorkshopProduct::class,"product_id","id");
    }

    public function cart_items()
    {
        return $this->belongsTo(WorkshopCartItem::class,"cart_item_id","id");
    }

}
