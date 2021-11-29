<?php

namespace App\Models\Repairs;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RepairProject extends Model
{
    protected $table = 'repair_projects';
    protected $guarded = [];

//    protected $with = ['users', 'locations', 'items', 'details'];

    const IMPORTANCE = [1 => '高', 2 => '中', 3 => '低', 4 => '定期性'];
    const STATUS_UNFINISHED = 1;
    const STATUS_CANCELED = 4;
    const STATUS_FINISHED = 99;

    public function users(): HasOne
    {
        return $this->hasOne(User::class,'id','user_id');
    }

    public function locations(): HasOne
    {
        return $this->hasOne(RepairLocation::class,'id','repair_location_id');
    }

    public function items(): HasOne
    {
        return $this->hasOne(RepairItem::class,'id','repair_item_id');
    }

    public function details(): HasOne
    {
        return $this->hasOne(RepairDetail::class,'id','repair_detail_id');
    }

    public static function getMaxSupportNo()
    {
        $cutword = 'R';
        $maxSupportNo = RepairProject::max('repair_project_no');
        $nowYear = Carbon::now()->isoFormat('YY');
        $maxYear = Str::before($maxSupportNo, $cutword);
        $number = Str::after($maxSupportNo, $cutword);
        if($nowYear > $maxYear){
            $repairNo = $nowYear.$cutword.'0001';
        }else{
            $number = str_pad(((int)$number + 1),4,'0',STR_PAD_LEFT);
            $repairNo = $nowYear.$cutword.$number;
        }

        return $repairNo;
    }

    public static function getUnfinishedSupport()
    {
        $allUnfinished = RepairProject::where('status',1)
            ->CurrUser()
            ->orderByDesc('updated_at')
            ->get();

        $allUnfinished = RepairProject::setImportance($allUnfinished);

        return $allUnfinished;

    }

    public static function getFinishedSupport()
    {
        $allFinished =  RepairProject::where('status',99)
            ->CurrUser()
            ->NotExpired(14)
            ->orderByDesc('updated_at')
            ->get();

        $allFinished = RepairProject::setImportance($allFinished);

        return $allFinished;

    }

    public static function getCanceledSupport()
    {
        $allCanceled =  RepairProject::where('status',4)
            ->CurrUser()
            ->NotExpired(14)
            ->orderByDesc('updated_at')
            ->get();

        $allCanceled = RepairProject::setImportance($allCanceled);

        return $allCanceled;

    }

    //將importance改成文字描述
    public static function setImportance($repairs)
    {
        foreach ($repairs as &$value)
        {
            $importanceArr = RepairProject::IMPORTANCE;
            if(isset($importanceArr[$value->importance])){
                $value->importance = $importanceArr[$value->importance];
            }else{
                $value->importance = "";
            }
        }

        return $repairs;
    }


    public function scopeCurrUser($query)
    {
//        if(Auth::user()->can('shop')){
//            //分店獲取當前登錄id
//            return $query->where('user_id', Auth::id());
//        }else if(Auth::user()->can('IT')){
//            //IT獲取全部
//            return $query;
//        }else{
//            //其他獲取不存在的id
//            return $query->where('user_id', 0);
//        }

        if(Auth::user()->can('IT')){
            //IT獲取全部
            return $query;
        }else{
            //其他獲取當前登錄id
            return $query->where('user_id', Auth::id());
        }

    }

    //設置多少天前不顯示
    public function scopeNotExpired($query,int $expiredDay)
    {
        $expired = Carbon::now()->subDay($expiredDay)->toDateString();

        return $query->whereDate('updated_at', '>' , $expired);

    }


}
