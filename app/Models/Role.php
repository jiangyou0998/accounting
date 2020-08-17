<?php

namespace App\Models;


use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    public function permissions(): BelongsToMany
    {
        $pivotTable = 'role_has_permissions'; // 中间表

        $relatedModel = Permission::class; // 关联模型类名

        return $this->belongsToMany($relatedModel, $pivotTable, 'role_id', 'permission_id');
    }

    public function users(): BelongsToMany
    {
        $pivotTable = 'model_has_roles'; // 中间表

        $relatedModel = User::class; // 关联模型类名

        return $this->belongsToMany($relatedModel, $pivotTable, 'role_id', 'model_id')
            ->withPivot('model_type')->withPivotValue('model_type','App\User');
    }


}
