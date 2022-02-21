<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class FrontGroupHasUser extends Model
{
	
    protected $table = 'front_group_has_users';

    protected $primaryKey = 'user_id';

    public $timestamps = false;

}
