<?php

namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ClaimLevelDetail extends Model
{

    protected $table = 'claim_level_details';

    protected $guarded = [];

    public $timestamps = false;

    public function claim_level()
    {
        return $this->belongsTo(ClaimLevel::class,'claim_level_id','id');
    }

    public static function getClaimLevelDetail($claim_level_id, $claim_date){

        $claim_level_detail = self::where('claim_level_id', $claim_level_id)
            ->where('start_date', '<=', $claim_date)
            ->where('end_date', '>=' , $claim_date)
            ->first();

        return $claim_level_detail;
    }

    //查詢每年索償次數
    public static function getTimesPerYear($claim_level_id, $claim_date){

        $times_per_year = self::getClaimLevelDetail($claim_level_id, $claim_date)->times_per_year ?? 0;

        return $times_per_year;
    }

    //查詢每天索償次數
    public static function getTimesPerDay($claim_level_id, $claim_date){

        $times_per_year = self::getClaimLevelDetail($claim_level_id, $claim_date)->times_per_day ?? 0;

        return $times_per_year;
    }


}
