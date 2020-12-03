<?php

namespace App\Models\Itsupport;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use function Sodium\increment;

class Itsupport extends Model
{

    protected $guarded = [];

    public function users()
    {
        return $this->hasOne(User::class,'id','user_id');
    }

    public function items()
    {
        return $this->hasOne(ItsupportItem::class,'id','itsupport_item_id');
    }

    public function details()
    {
        return $this->hasOne(ItsupportDetail::class,'id','itsupport_detail_id');
    }

    public static function getMaxSupportNo()
    {
        $cutword = 'IT';
        $maxSupportNo = Itsupport::max('it_support_no');
        $nowYear = Carbon::now()->isoFormat('YY');
        $maxYear = Str::before($maxSupportNo, $cutword);
        $number = Str::after($maxSupportNo, $cutword);
        if($nowYear > $maxYear){
            $itSupportNo = $nowYear.$cutword.'0001';
        }else{
            $number = str_pad(((int)$number + 1),4,'0',STR_PAD_LEFT);
            $itSupportNo = $nowYear.$cutword.$number;
        }

        return $itSupportNo;
    }

    public static function getUnfinishedSupport()
    {
        $allUnfinished = Itsupport::with('users')
            ->with('items')
            ->with('details')
            ->where('status',1)
            ->CurrUser()
            ->orderByDesc('created_at')
            ->get();

        return $allUnfinished;

    }

    public static function getFinishedSupport()
    {
        $allFinished =  Itsupport::with('users')
            ->with('items')
            ->with('details')
            ->where('status',99)
            ->CurrUser()
            ->orderByDesc('created_at')
            ->get();

        return $allFinished;

    }

    public static function getCanceledSupport()
    {
        $allCanceled =  Itsupport::with('users')
            ->with('items')
            ->with('details')
            ->where('status',4)
            ->CurrUser()
            ->orderByDesc('created_at')
            ->get();

        return $allCanceled;

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


}
