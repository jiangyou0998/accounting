<?php

namespace App;

use App\Models\FrontGroup;
use App\Models\Library\Library;
use App\Models\Role;
use App\Models\ShopAddress;
use App\Models\ShopGroup;
use App\Models\ShopSubGroup;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

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

    public function address()
    {
        return $this->belongsTo(ShopAddress::class,'address_id','id');
    }

    public function roles(): BelongsToMany
    {
        $pivotTable = 'model_has_roles'; // 中间表

        $relatedModel = Role::class; // 关联模型类名

        return $this->belongsToMany($relatedModel, $pivotTable, 'model_id', 'role_id')
            ->withPivot('model_type')->withPivotValue('model_type','App\User')->with('permissions');
    }

    public function shop_groups(): BelongsToMany
    {
        $pivotTable = 'shop_group_has_users'; // 中间表

        $relatedModel = ShopGroup::class; // 关联模型类名

        return $this->belongsToMany($relatedModel, $pivotTable, 'user_id', 'shop_group_id');
    }

    public function shop_sub_groups(): BelongsToMany
    {
        $pivotTable = 'shop_sub_group_has_users'; // 中间表

        $relatedModel = ShopSubGroup::class; // 关联模型类名

        return $this->belongsToMany($relatedModel, $pivotTable, 'user_id', 'shop_sub_group_id');
    }

    public function front_groups(): BelongsToMany
    {
        $pivotTable = 'front_group_has_users'; // 中间表

        $relatedModel = FrontGroup::class; // 关联模型类名

        return $this->belongsToMany($relatedModel, $pivotTable, 'user_id', 'front_group_id');
    }

    public function librarys(): MorphToMany
    {
        return $this->morphedByMany(
            Library::class,
            'model',
            'front_user_can_views',
            'user_id',
            'model_id'
        );
    }

    public function allNodes()
    {

        return User::get(['id','name'])->toArray();
    }

    public function isOnline()
    {
        return Cache::has('user-is-online-' . $this->id);
    }

    public static function getKingBakeryShops(){

        $users = new User();
        $shops = $users
            ->where('name','like','kb%')
            ->orWhere('name','like','ces%')
            ->orWhere('name','like','b&b%')
            ->orderBy('name')
            ->get(['id','report_name']);

        return $shops;
    }

    public static function getKingBakeryShopsOrderBySort(){

        $users = new User();
        $shops = $users
            ->where('name','like','kb%')
            ->orWhere('name','like','ces%')
            ->orWhere('name','like','b&b%')
            ->orderBy('sort')
            ->get(['id','report_name']);

        return $shops;
    }

    public static function getRyoyuBakeryShops(){

        $users = new User();
        $shops = $users
            ->where('name','like','rb%')
            ->orderBy('name')
            ->get(['id','report_name']);

        return $shops;
    }

    //獲取蛋撻王和糧友所有分店
    public static function getAllShops(){

        $users = new User();
        $shops = $users
            ->where('name','like','kb%')
            ->orWhere('name','like','ces%')
            ->orWhere('name','like','b&b%')
            ->orWhere('name','like','rb%')
            ->orderBy('name')
            ->get(['id','report_name']);

        return $shops;
    }

    //獲取 蛋撻王 和 糧友 和 外客 所有分店
    public static function getAllShopsAndCustomerShops(){

        $users = new User();
        $shops = $users
            ->leftJoin('shop_group_has_users', 'shop_group_has_users.user_id', '=', 'users.id')
            ->has('shop_groups')
            ->orderBy('shop_group_has_users.shop_group_id')
            ->orderBy('name')
            ->get(['id','report_name']);

        return $shops;
    }

    public static function getCustomerShops(){

        $users = new User();
        $shops = $users
            ->whereHas('shop_groups', function ($query){
                $query->whereNotIn('id', [1,5]);
            })
            ->orderBy('name')
            ->get(['id','report_name']);

        return $shops;
    }

    // 獲取所有加入shop_group的用戶
    public static function getAllShopsByShopGroup(){

        $users = new User();
        $shops = $users
            ->has('shop_groups')
            ->orderBy('name')
            ->get();

        return $shops;
    }

    //根據shop_group的id,獲取分店
    public static function getShopsByShopGroup($shop_group_id){

        $users = new User();
        $shops = $users
            ->whereHas('shop_groups', function ($query) use($shop_group_id){
                if(is_array($shop_group_id)){
                    $query->whereIn('id', $shop_group_id);
                }else{
                    $query->where('id', '=', $shop_group_id);
                }
            })
            ->orderBy('name')
            ->get(['id','report_name']);

        return $shops;
    }

    //2022-09-02 根據shop_sub_group的id,獲取分店資料
    public static function getShopsByShopSubGroup($shop_sub_group_id){

        $users = new User();
        $shops = $users
            ->whereHas('shop_sub_groups', function ($query) use($shop_sub_group_id){
                if(is_array($shop_sub_group_id)){
                    $query->whereIn('id', $shop_sub_group_id);
                }else{
                    $query->where('id', '=', $shop_sub_group_id);
                }
            })
            ->orderBy('name')
            ->get(['id','report_name']);

        return $shops;
    }

    //根據user表的id,獲取分店shop_group_id
    public static function getShopGroupId($shop_id){
        $query = self::query();
        return $query->find($shop_id)->shop_groups->first()->id ?? 0;
    }

    public static function getTestUserIDs(){

        $testUserIDs = [1,2,3,4,77,82];

        return $testUserIDs;
    }

    public static function getShopId($shop){

        //商店獲取商店id,不管傳的是什麼id
        $users = Auth::user();
        if ($users->can('shop')){
            $shop = $users->id;
        }

        return $shop;
    }

    public function allShopNodes()
    {
        $user = new User();
        $user = $user->with('shop_groups')
            ->has('shop_groups')
            ->get();
        return $user;
    }
}
