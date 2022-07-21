<?php

namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class WarehouseStockItemForbidden extends Model
{

    protected $table = 'warehouse_stock_item_forbidden';

    public function users()
    {
        $userModel = config('admin.database.users_model');

        return $this->belongsTo($userModel,"user_id","id");
    }

    public static function checkModifyPermission($modify_date){

        $month = Carbon::parse((string)$modify_date)->isoFormat('YMM');

        return WarehouseStockItemForbidden::query()
            ->where('month', $month)
            ->count();
    }

}
