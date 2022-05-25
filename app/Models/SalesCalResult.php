<?php

namespace App\Models;


use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SalesCalResult extends Model
{

    protected $table = 'sales_cal_results';

    public function user()
    {
        return $this->belongsTo(User::class,'shop_id','id');
    }

    public function details()
    {
        return $this->hasMany(SalesIncomeDetail::class, 'sales_cal_result_id', 'id');
    }

    public function octopus_income()
    {
        return $this->hasOne(SalesIncomeDetail::class, 'sales_cal_result_id', 'id')
            ->where('type_no', 31);
    }

    public function scopeMaxDay($query, $date)
    {
        if(is_null($date)){
            return $query;
        }

        return $query->whereDate('date', '<', $date);
    }

    public static function getSalesCalResult($date = null)
    {
        $date = getRequestDateOrNow($date);
        $shop_id = Auth::user()->id;

        $sales_cal_result = self::query()
            ->where('date', $date)
            ->where('shop_id', $shop_id)
            ->first();

        return $sales_cal_result;
    }

    public static function getNewDepositNo($date = null)
    {
        $date_carbon = $date ? Carbon::parse($date) : Carbon::now();
        $year_and_month = $date_carbon->isoFormat('YYMM');
        $year_and_month = (int)$year_and_month * 10000;

        //從數據庫查出最大的編號
        $max_deposit_no = self::getMaxDepositNo($date);
        if($year_and_month > $max_deposit_no || is_null($max_deposit_no)){
            $new_deposit_no = $year_and_month + 1;
        }else{
            $new_deposit_no = $max_deposit_no + 1;
        }
        return $new_deposit_no;
    }

    //獲取承上結餘
    public static function getLastBalance($date = null)
    {
        $date = getRequestDateOrNow($date);
        //從數據庫查出最大的編號
        $max_deposit_no = self::getMaxDepositNo($date);
        if(is_null($max_deposit_no)){
            $last_balance = 0;
        }else{
            $shop_id = Auth::user()->id;
            $last_balance = self::query()->where('shop_id', $shop_id)
                ->where('deposit_no', $max_deposit_no)
                ->maxDay($date)
                ->first()->balance ?? 0;
        }
        return $last_balance;
    }

    //獲取承上夾萬結餘
    public static function getLastSafeBalance($date = null)
    {
        $date = getRequestDateOrNow($date);
        //從數據庫查出最大的編號
        $max_deposit_no = self::getMaxDepositNo($date);
        if(is_null($max_deposit_no)){
            $last_safe_balance = 0;
        }else{
            $shop_id = Auth::user()->id;
            $last_safe_balance = self::query()->where('shop_id', $shop_id)
                ->where('deposit_no', $max_deposit_no)
                ->maxDay($date)
                ->first()->safe_balance ?? 0;
        }
        return $last_safe_balance;
    }

    private static function getMaxDepositNo($date = null)
    {
        //從數據庫查出最大的編號
        $date = getRequestDateOrNow($date);
        $shop_id = Auth::user()->id;
        //從數據庫查出最大的編號
        $max_deposit_no = self::query()
            ->where('shop_id', $shop_id)
            ->maxDay($date)
            ->max('deposit_no');

        return $max_deposit_no;
    }

    //獲取key為shop_id, value為總收入的數組
    public static function getShopIdAndTotalIncome($date, $type)
    {
        switch ($type){
            case 'month':
                $start_date = Carbon::parse($date)->startOfMonth()->toDateString();
                break;
            case 'week':
                $start_date = Carbon::parse($date)->startOfWeek()->toDateString();
                break;
            case 'day':
                $start_date = $date;
                break;
        }

        $total_income = SalesCalResult::select(['shop_id', DB::raw("SUM(`income_sum`) as sum")])
            ->whereBetween('date', [$start_date, $date])
            ->groupBy('shop_id')
            ->get()
            ->pluck('sum', 'shop_id')
            ->toArray();

        return $total_income;
    }

    //2022-04-19 獲取上個月同一個總計
    //2022-05-17 暫未使用
    public static function getShopIdAndLastMonthTotalAtSameDay($date)
    {
        $same_day_of_last_month_carbon = Carbon::parse($date)->subMonthNoOverflow();

        $same_day_of_last_month = $same_day_of_last_month_carbon->toDateString();

        //獲取上個月第一天
        $first_day_of_last_month = $same_day_of_last_month_carbon->firstOfMonth()->toDateString();

//        dump($first_day_of_last_month);
//        dump($same_day_of_last_month);

        $last_month_total = self::query()
            ->select(['shop_id', DB::raw("SUM(`income_sum`) as sum")])
            ->whereBetween('date', [$first_day_of_last_month, $same_day_of_last_month])
            ->groupBy('shop_id')
            ->get()
            ->pluck('sum', 'shop_id')
            ->toArray();

//        dump($last_month_total);

        return $last_month_total;
    }

    //2022-05-19 獲取時節數
    public static function getShopIdAndSeasonalIncome($date = null)
    {
        $date = getRequestDateOrNow($date);

        $ids = self::query()
            ->whereDate('date', $date)
            ->get('id');

        $seasonal_income = SalesIncomeDetail::with('sales_cal_result')
            ->whereIn('sales_cal_result_id', $ids)
            ->where('type_no', 91)
            ->get()
            ->mapWithKeys(function ($item, $key) {
                return [$item['sales_cal_result']['shop_id'] => $item['income']];
            })
            ->toArray();

        return $seasonal_income;
    }


}
