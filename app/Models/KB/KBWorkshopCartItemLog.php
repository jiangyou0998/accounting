<?php

namespace App\Models\KB;


use App\User;
use Illuminate\Database\Eloquent\Model;

class KBWorkshopCartItemLog extends Model
{
    protected $connection = 'mysql_kb';
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
        return $this->belongsTo(KBWorkshopProduct::class,"product_id","id");
    }

    public function cart_items()
    {
        return $this->belongsTo(KBWorkshopCartItem::class,"cart_item_id","id");
    }

}
