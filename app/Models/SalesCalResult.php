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

    public static function getSalesCalResult()
    {
        $date = Carbon::now()->toDateString();
        $shop_id = Auth::user()->id;

        $sales_cal_result = self::query()
            ->where('date', $date)
            ->where('shop_id', $shop_id)
            ->first();

        return $sales_cal_result;
    }

    public static function getNewDepositNo()
    {
        $year_and_month = Carbon::now()->isoFormat('YYMM');
        $year_and_month = (int)$year_and_month * 10000;

        //從數據庫查出最大的編號
        $max_deposit_no = self::getMaxDepositNo();
        if($year_and_month > $max_deposit_no || is_null($max_deposit_no)){
            $new_deposit_no = $year_and_month + 1;
        }else{
            $new_deposit_no = $max_deposit_no + 1;
        }
        return $new_deposit_no;
    }

    //獲取承上結餘
    public static function getLastBalance()
    {
        //從數據庫查出最大的編號
        $max_deposit_no = self::getMaxDepositNo();
        if(is_null($max_deposit_no)){
            $last_balance = 0;
        }else{
            $shop_id = Auth::user()->id;
            $last_balance = self::query()->where('shop_id', $shop_id)
                ->where('deposit_no', $max_deposit_no)
                ->first()->balance;
        }
        return $last_balance;
    }

    //獲取承上夾萬結餘
    public static function getLastSafeBalance()
    {
        //從數據庫查出最大的編號
        $max_deposit_no = self::getMaxDepositNo();
        if(is_null($max_deposit_no)){
            $last_safe_balance = 0;
        }else{
            $shop_id = Auth::user()->id;
            $last_safe_balance = self::query()->where('shop_id', $shop_id)
                ->where('deposit_no', $max_deposit_no)
                ->first()->safe_balance;
        }
        return $last_safe_balance;
    }

    private static function getMaxDepositNo()
    {
        //從數據庫查出最大的編號
        $date = Carbon::now()->toDateString();
        $shop_id = Auth::user()->id;
        //從數據庫查出最大的編號
        $max_deposit_no = self::query()
            ->where('shop_id', $shop_id)
            ->where('date', '!=', $date)
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
        }

        $total_income = SalesCalResult::select(['shop_id', DB::raw("SUM(`income_sum`) as sum")])
            ->whereBetween('date', [$start_date, $date])
            ->groupBy('shop_id')
            ->get()
            ->pluck('sum', 'shop_id')
            ->toArray();

        return $total_income;
    }


}
