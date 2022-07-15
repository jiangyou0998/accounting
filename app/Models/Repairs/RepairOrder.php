<?php

namespace App\Models\Repairs;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RepairOrder extends Model
{
    protected $table = 'repair_orders';
    protected $guarded = [];

    public function repair_projects()
    {
        return $this->hasMany(RepairProject::class,"repair_order_id","id")
            ->with(['users', 'locations', 'items', 'details']);
    }

    public static function getMaxOrderNo($shop_id)
    {
        $cutword = User::find($shop_id)->pocode ?? 'OF';

        $nowYear = Carbon::now()->isoFormat('YY');

        if($cutword === 'OF'){
            $maxSupportNo = RepairOrder::where('order_no', 'like', $nowYear.$cutword.'%')->max('order_no');
        }else{
            $maxSupportNo = RepairOrder::where('user_id', $shop_id)->max('order_no');
        }
        $maxYear = Str::before($maxSupportNo, $cutword);
        $number = Str::after($maxSupportNo, $cutword);
        if($nowYear > $maxYear){
            $orderNo = $nowYear.$cutword.'0001';
        }else{
            $number = str_pad(((int)$number + 1),4,'0',STR_PAD_LEFT);
            $orderNo = $nowYear.$cutword.$number;
        }

        return $orderNo;
    }

    public static function getRepairOrderByShop($shop_id)
    {
        $orders = self::query()
            ->with('repair_projects')
            ->where('user_id', $shop_id)
            ->get();

        return $orders;
    }

}
