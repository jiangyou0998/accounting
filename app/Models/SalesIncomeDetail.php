<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class SalesIncomeDetail extends Model
{

    protected $table = 'sales_income_details';

    public static function getSalesIncomeDetailArray($sales_cal_result_id)
    {
        return SalesIncomeDetail::query()
                ->where('sales_cal_result_id', $sales_cal_result_id)
                ->pluck('income', 'type_no')
                ->toArray();
    }

    public static function getBank($sales_cal_result_id)
    {
        return SalesIncomeDetail::query()
                ->where('sales_cal_result_id', $sales_cal_result_id)
                ->where('type_no', 72)
                ->first()->remark ?? null;
    }

}
