<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ShopGroupHasUser extends Model
{
	
    protected $table = 'shop_group_has_users';

    protected $primaryKey = 'user_id';

    public $timestamps = false;

}
