<?php

namespace App;

use App\Models\FrontGroup;
use App\Models\Library\Library;
use App\Models\Role;
use App\Models\ShopAddress;
use App\Models\ShopGroup;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Traits\HasRoles;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

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

    // 獲取所有加入shop_group的用戶
    public static function getAllShopsByShopGroup(){

        $users = new User();
        $shops = $users
            ->has('shop_groups')
            ->orderBy('name')
            ->get();

        return $shops;
    }

    //$type 麵包部-bakery 廚房-kitchen 水吧-waterbar
    //根據type獲取KB內聯網對應account id
    public static function getKBUserIDByType($type)
    {
        $user = Auth::user();
        $shopid = -1;

        switch (strtolower($type)){
            case 'bakery':
                $shopid = $user->kb_bakery_id;
                break;

            case 'kitchen':
                $shopid = $user->kb_kitchen_id;
                break;

            case 'waterbar':
                $shopid = $user->kb_waterbar_id;
                break;
        }

        //未選擇下單部門
        if ($shopid === -1) {
            throw new AccessDeniedHttpException('未選擇部門');
        }

        //找不到蛋撻王內聯網ID
        if ($shopid === null) {
            throw new AccessDeniedHttpException('未綁定蛋撻王內聯網賬號，請聯繫管理員！');
        }

        return $shopid;

    }

    //獲取某用戶在蛋撻王內聯網對應的ID
    public static function getKBIds($shop)
    {
        $kb_ids = [];
        $user = self::query()->find($shop);

        if(isset($user->kb_bakery_id)){
            $kb_ids[] = $user->kb_bakery_id;
        }

        if(isset($user->kb_kitchen_id)){
            $kb_ids[] = $user->kb_kitchen_id   ;
        }

        if(isset($user->kb_waterbar_id)){
            $kb_ids[] = $user->kb_waterbar_id;
        }

        return $kb_ids;
    }

    //獲取蛋撻王內聯網ID及部門名數組
    public static function getKBIdAndDeptName($user_id = null){
        if(is_null($user_id)){
            $user = Auth::user();
        }else{
            $user = self::find($user_id);
        }

        $result = [];
        if(isset($user->kb_bakery_id)){
            $result[$user->kb_bakery_id] = '包部';
        }

        if(isset($user->kb_kitchen_id)){
            $result[$user->kb_kitchen_id] = '廚房';
        }

        if(isset($user->kb_waterbar_id)){
            $result[$user->kb_waterbar_id] = '水吧';
        }

        return $result;
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

}
