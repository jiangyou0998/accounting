<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{

//    public function roles()
//    {
//        return $this->belongsToMany(Role::class);
//    }

    public function allNodes()
    {
        return Permission::get(['id','name'])->toArray();
    }
}
