<?php

namespace App\Models;


use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ShopGroup extends Model
{
    //當前內聯網所屬商店分組ID
    const CURRENT_SHOP_ID = 5;

    protected $table = 'shop_groups';

    public function price()
    {
        return $this->hasMany(Price::class,"shop_group_id" , "id");
    }

    public function users(): BelongsToMany
    {
        $pivotTable = 'shop_group_has_users'; // 中间表

        $relatedModel = User::class; // 关联模型类名

        return $this->belongsToMany($relatedModel, $pivotTable, 'shop_group_id', 'user_id')->orderBy('users.name');
    }

//    public function users_with_addresses(): BelongsToMany
//    {
//        $pivotTable = 'shop_group_has_users'; // 中间表
//
//        $relatedModel = User::class; // 关联模型类名
//
//        return $this->belongsToMany($relatedModel, $pivotTable, 'shop_group_id', 'user_id')->with('address');
//    }

    public function users_with_addresses()
    {
        return $this->users()->with('address');
    }




}
