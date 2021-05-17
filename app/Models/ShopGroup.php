<?php

namespace App\Models;


use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ShopGroup extends Model
{

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

    //獲取外客分組
    public static function getCustomerGroup()
    {
        $query = self::query();
        return $query->whereNotIn('name',['蛋撻王','共食薈','一口烘焙','糧友'])->get();
    }

    public static function getShopGroupName($id)
    {
        $query = self::query();
        return $query->find($id)->name ?? '';
    }




}
