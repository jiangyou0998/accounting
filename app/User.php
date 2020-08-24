<?php

namespace App;

use App\Models\Role;
use App\Models\TblUser;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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

    public function roles(): BelongsToMany
    {
        $pivotTable = 'model_has_roles'; // 中间表

        $relatedModel = Role::class; // 关联模型类名

        return $this->belongsToMany($relatedModel, $pivotTable, 'model_id', 'role_id')
            ->withPivot('model_type')->withPivotValue('model_type','App\User');
    }

    public function allNodes()
    {

        return User::get(['id','name'])->toArray();
    }


}
