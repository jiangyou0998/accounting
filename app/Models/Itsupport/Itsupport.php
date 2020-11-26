<?php

namespace App\Models\Itsupport;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
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


}
