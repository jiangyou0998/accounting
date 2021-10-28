<?php

namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{
    protected $guarded = [];

    const STATUS_APPLYING = 0;
    const STATUS_APPROVED = 1;

    public function user()
    {
        $userModel = config('admin.database.users_model');

        return $this->belongsTo($userModel,"approver_id","id");
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class,'employee_id','id');
    }

    public function claim_level()
    {
        return $this->belongsTo(ClaimLevel::class,'claim_level_id','id');
    }

    public function illness()
    {
        return $this->hasOne(SelectorItem::class, 'id', 'illness_id')
            ->where('type_name', '=', 'claim_illness');
    }

    public function scopeOfClaimLevel($query, $claim_level_ids = [])
    {
        if($claim_level_ids){
            return $query->whereIn('claim_level_id', $claim_level_ids);
        }else{
            return $query;
        }
    }

    public function scopeOfStatus($query, $status = -1)
    {
        if($status >= 0){
            return $query->where('status', $status);
        }else{
            return $query;
        }
    }

    public static function calculateClaimCost($cost, $claim_level_id, $claim_date)
    {
        //索償百分比為0-100
        $claim_level = ClaimLevelDetail::where('claim_level_id', $claim_level_id)
            ->where('start_date', '<=', $claim_date)
            ->where('end_date', '>=' , $claim_date)
            ->first();

        if(! $claim_level) return false;

        $rate = $claim_level->rate;
        $max_claim_money = $claim_level->max_claim_money;
        $claim_cost = $cost * $rate / 100 ;

        if($claim_cost > $max_claim_money){
            $claim_cost = $max_claim_money;
        }

        return $claim_cost;

    }

    //獲取所有相同plan_code的claim_level_id
    public static function getAllClaimLevelID($claim_level_id){

        $claim_level = ClaimLevel::find($claim_level_id);
        $plan_code = $claim_level->plan_code ?? -1;
        $all_claim_level_id = ClaimLevel::where('plan_code', $plan_code)->pluck('id');

        return $all_claim_level_id;
    }

    //
    public static function getTimesOfDay($employee_id, $claim_level_id, $claim_date, $id = 0){

        $all_claim_level_id = self::getAllClaimLevelID($claim_level_id);

        $times_of_day = self::where('claim_date', $claim_date)
            ->where('employee_id', $employee_id)
            ->whereIn('claim_level_id', $all_claim_level_id)
            ->where('id', '!=', $id)
            ->where('status', 1)
            ->count();

        return $times_of_day;
    }


    //
    public static function getTimesOfYear($employee_id, $claim_level_id, $claim_date, $id = 0){

        $all_claim_level_id = self::getAllClaimLevelID($claim_level_id);

        $year_start = Carbon::parse($claim_date)->firstOfYear()->toDateString();
        $year_end = Carbon::parse($claim_date)->endOfYear()->toDateString();
        $times_of_year = self::whereBetween('claim_date', [ $year_start, $year_end ])
            ->where('employee_id', $employee_id)
            ->whereIn('claim_level_id', $all_claim_level_id)
            ->where('id', '!=', $id)
            ->where('status', 1)
            ->count();

        return $times_of_year;
    }

    //前台獲取claim次數,類型等信息
    public static function getClaimMessage($employee_id, $claim_level_id, $claim_date){
//        $times_of_day_applying = self::where('claim_date', $claim_date)
//            ->where('employee_id', $employee_id)
//            ->where('claim_level_id', $claim_level_id)
//            ->where('status', 0)
//            ->count();

        $times_of_year = self::getTimesOfYear($employee_id, $claim_level_id, $claim_date);

//        $data = new Collection();
//        $data->times_of_day = $times_of_day;
//        $data->times_of_year = $times_of_year;

        $claim_level = ClaimLevel::find($claim_level_id);
        $claim_level_detail = ClaimLevelDetail::getClaimLevelDetail($claim_level_id, $claim_date);

        $data = [
//            'times_of_day_applying' => $times_of_day_applying,
            'times_of_year' => $times_of_year,
            'times_per_year' => $claim_level_detail->times_per_year ?? 0,
            'claim_type' => $claim_level->type_name,
            'rate' => $claim_level_detail->rate ?? '',
            'max_claim_money' => $claim_level_detail->max_claim_money ?? '',
        ];

        return $data;
    }

    //檢測已申請成功次數
    //true 次數未超過
    //false 次數超過
    public static function checkClaimTimes($employee_id, $claim_level_id, $claim_date){

        $times_of_year = self::getTimesOfYear($employee_id, $claim_level_id, $claim_date);

        $times_per_year = ClaimLevelDetail::getTimesPerYear($claim_level_id, $claim_date);

        if ($times_per_year === 0){
            return 'NO_PLAN';
        }

        return $times_of_year < $times_per_year;

    }

    //檢測是否超過索償時間
    public static function checkExpiredDate($claim_date, $expired_day){

        $now = Carbon::today();
        $claim_date_carbon = carbon::parse($claim_date);
        $diff = $now->diffInDays($claim_date_carbon);

        return $diff <= $expired_day && $diff >= 0;

    }

}
