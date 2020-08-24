<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{

    public function roles(): BelongsToMany
    {
        $pivotTable = 'role_has_permissions'; // 中间表

        $relatedModel = Role::class; // 关联模型类名

        return $this->belongsToMany($relatedModel, $pivotTable, 'permission_id', 'role_id');
    }

    public function allNodes()
    {
        return Permission::get(['id','name'])->toArray();
    }
}
