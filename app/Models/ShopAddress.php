<?php

namespace App\Models;


use App\User;
use Illuminate\Database\Eloquent\Model;

class ShopAddress extends Model
{

    protected $table = 'shop_address';
    public $timestamps = false;

    public function users()
    {
        return $this->belongsTo(User::class,'id','address_id');
    }

}
