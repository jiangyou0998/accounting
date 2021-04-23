<?php

namespace App\Models;


use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class FrontGroup extends Model
{

    protected $table = 'front_groups';

    public function users(): BelongsToMany
    {
        $pivotTable = 'front_group_has_users'; // 中间表

        $relatedModel = User::class; // 关联模型类名

        return $this->belongsToMany($relatedModel, $pivotTable, 'front_group_id', 'user_id')->orderBy('users.name');
    }

}
