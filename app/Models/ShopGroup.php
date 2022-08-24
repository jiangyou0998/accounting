<?php

namespace App\Models;


use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ShopGroup extends Model
{
    //當前內聯網所屬商店分組ID
    const CURRENT_SHOP_ID = 1;
    const KB_SHOP_ID = 1;
    const TWOCAFE_SHOP_ID = 4;
    const RB_SHOP_ID = 5;
    const LAGARDERE_SHOP_ID = 8;
    const MANTAI_SHOP_ID = 9;
    const TO_GATHER_CAFE_SHOP_ID = 10;

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

    public function scopeCustomerShop($query)
    {
        return $query->whereNotIn('id', [1, 5]);
    }

    public function scopeOnlyKB($query)
    {
        return $query->where('id', 1);
    }

    //獲取外客分組
    public static function getCustomerGroup()
    {
        $query = self::query();

        //2022-08-24 隱藏滿泰 To-Gather Cafe
        $hide_customer_ids = [
            self::KB_SHOP_ID,
            self::RB_SHOP_ID,
            self::MANTAI_SHOP_ID,
            self::TO_GATHER_CAFE_SHOP_ID
        ];
        return $query->whereNotIn('id', $hide_customer_ids)->orderBy('sort')->get();
    }

    public static function getShopGroupName($id)
    {
        $query = self::query();
        return $query->find($id)->name ?? '';
    }




}
