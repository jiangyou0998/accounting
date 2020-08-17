<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

//    protected $table = 'tbl_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function allNodes()
    {
//        $user = array(['蛋撻王'=>array('id'=>'1','name'=>'大業')]);
//        $user = array(['蛋撻王'=>
//            array([('id'=>'1','name'=>'大業')])
//        ]);
//        dump($user);
//        dump(User::get(['id','name'])->toArray());
//        return $user;
        return User::get(['id','name'])->toArray();
    }


}
