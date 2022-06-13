<?php

namespace App\Http\Traits;

use App\Models\SalesBill;
use App\Models\SalesCalResult;
use App\Models\SalesIncomeDetail;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;

trait SalesDataTableTraits
{
    //打印報表表格內容
    private function getAllSalesTableData($start_date, $end_date, $shop_ids)
    {
        $sales_cal_results = SalesCalResult::query()
            ->whereBetween('date', [$start_date, $end_date])
            ->whereIn('shop_id', $shop_ids)
            ->get();

        $sales_cal_result_ids = $sales_cal_results->pluck('id');

        $sales_income_details = SalesIncomeDetail::query()
            ->whereIn('sales_cal_result_id', $sales_cal_result_ids)
            ->get();

        $banks = SalesIncomeDetail::query()
            ->whereIn('sales_cal_result_id', $sales_cal_result_ids)
            ->where('type_no', 72)
            ->get();

        $users = User::all()->pluck('report_name', 'id')->toArray();

        $all_sales_table_data = array();

        foreach ($sales_cal_results as $sales_cal_result){

            $sales_cal_result_id = $sales_cal_result->id;
            $date = $sales_cal_result->date;
            $shop_id = $sales_cal_result->shop_id;

            $sales_income_detail = $sales_income_details->where('sales_cal_result_id', $sales_cal_result_id)
                ->pluck('income', 'type_no')
                ->toArray();

            $bank = $banks->where('sales_cal_result_id', $sales_cal_result_id)
                    ->where('type_no', 72)
                    ->first()->remark ?? null;

            //計算POS收入
            $pos_income_sum = 0.00;
            if(isset($sales_income_detail['12'])){
                $pos_income_sum += (float)($sales_income_detail['12']);
            }

            if(isset($sales_income_detail['14'])){
                $pos_income_sum += (float)($sales_income_detail['14']);
            }

            //計算紙幣收入(=結存-硬幣)
            $pos_paper_money = 0.00;
            if(isset($sales_cal_result->balance)){
                $pos_paper_money += (float)($sales_cal_result->balance);
            }

            if(isset($sales_income_detail['42'])){
                $pos_paper_money -= (float)($sales_income_detail['42']);
            }

            if(isset($sales_income_detail['49'])){
                $pos_paper_money -= (float)($sales_income_detail['49']);
            }

            //2022-04-07 注意千位加逗號號不能再進行計算
            $sales_income_detail = array_map(function($n) {return number_format($n, 2);}, $sales_income_detail);

            $sales_table_data['pos_income'] = number_format($pos_income_sum, 2);

            $sales_table_data['morning_income'] = $sales_income_detail['21'] ?? '';
            $sales_table_data['afternoon_income'] = $sales_income_detail['22'] ?? '';
            $sales_table_data['evening_income'] = $sales_income_detail['23'] ?? '';

            $sales_table_data['octopus_income'] = $sales_income_detail['31'] ?? '';
            $sales_table_data['alipay_income'] = $sales_income_detail['32'] ?? '';
            $sales_table_data['wechatpay_income'] = $sales_income_detail['33'] ?? '';
            $sales_table_data['coupon_income'] = $sales_income_detail['34'] ?? '';
            $sales_table_data['credit_card_income'] = $sales_income_detail['35'] ?? '';

            $sales_table_data['pos_paper_money'] = number_format($pos_paper_money, 2);
            $sales_table_data['pos_coin'] = $sales_income_detail['42'] ?? '';
            $sales_table_data['pos_cash_not_deposited'] = $sales_income_detail['49'] ?? '';

            $sales_table_data['pos_money_1000'] = $sales_income_detail['43'] ?? '';
            $sales_table_data['pos_money_500'] = $sales_income_detail['44'] ?? '';
            $sales_table_data['pos_money_100'] = $sales_income_detail['45'] ?? '';
            $sales_table_data['pos_money_50'] = $sales_income_detail['46'] ?? '';
            $sales_table_data['pos_money_20'] = $sales_income_detail['47'] ?? '';
            $sales_table_data['pos_money_10'] = $sales_income_detail['48'] ?? '';

            if(isset($sales_cal_result->difference) && $sales_cal_result->difference > 0){
                $sales_table_data['difference'] = '+$'.(number_format($sales_cal_result->difference, 2) ?? '');
            }else{
                $sales_table_data['difference'] = '-$'.(number_format($sales_cal_result->difference, 2) ?? '');
            }

            //收入
            $sales_table_data['income_sum'] = number_format($sales_cal_result->income_sum, 2) ?? '';

            //存入銀行
            $sales_table_data['bank'] = $bank;
            $sales_table_data['deposit_in_bank'] = $sales_income_detail['72'] ?? '';

            $sales_table_data['last_balance'] = number_format($sales_cal_result->last_balance, 2) ?? '';
            $sales_table_data['balance'] = number_format($sales_cal_result->balance, 2) ?? '';

            $all_sales_table_data[$shop_id][$date]['data'] = $sales_table_data;

            $print_info = new Collection();
            $print_info->deposit_no = $sales_cal_result->deposit_no ?? '';
            $print_info->date = Carbon::parse($date)->isoFormat('YYYY年MM月DD日');
            $print_info->shop_name = $users[$shop_id];

            $all_sales_table_data[$shop_id][$date]['print_info'] = $print_info;

        }

//        dd($all_sales_table_data);

        return $all_sales_table_data;
    }
}
