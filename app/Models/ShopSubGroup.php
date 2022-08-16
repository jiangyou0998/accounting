<?php

namespace App\Models;


use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ShopSubGroup extends Model
{
    protected $table = 'shop_sub_groups';

    public function users(): BelongsToMany
    {
        $pivotTable = 'shop_sub_group_has_users'; // 中间表

        $relatedModel = User::class; // 关联模型类名

        return $this->belongsToMany($relatedModel, $pivotTable, 'shop_sub_group_id', 'user_id')->orderBy('users.name');
    }

    public function shop_group()
    {
        return $this->belongsTo(ShopGroup::class,'shop_group_id','id');
    }

}
