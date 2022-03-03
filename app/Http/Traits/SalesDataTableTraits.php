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

        $all_sales_bills = SalesBill::query()
            ->whereBetween('date', [$start_date, $end_date])
            ->whereIn('shop_id', $shop_ids)
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

            $sales_bills = $all_sales_bills->where('date', $date)
                ->where('shop_id', $shop_id);
            $bill_count = $sales_bills->count();

            //計算紙幣總數
            $paper_money_sum = 0.00;
            if(isset($sales_income_detail['41'])){
                $paper_money_sum += (float)($sales_income_detail['41']);
            }

            if(isset($sales_income_detail['51'])){
                $paper_money_sum += (float)($sales_income_detail['51']);
            }
            $paper_money_sum = sprintf("%.2f", $paper_money_sum);

            //計算硬幣總數
            $coin_sum = 0.00;
            if(isset($sales_income_detail['42'])){
                $coin_sum += (float)($sales_income_detail['42']);
            }

            if(isset($sales_income_detail['52'])){
                $coin_sum += (float)($sales_income_detail['52']);
            }
            $coin_sum = sprintf("%.2f", $coin_sum);

            //第一個參數為行 第二個參數為列
            $sales_table_data = [];
            for ($i=1; $i<=25; $i++){
                for ($j=1; $j<=5; $j++){
                    $sales_table_data[$i][$j] = '';
                }
            }
            $footer_start_line_num = 17;
            $bill_start_line_num = 6;


            //承上結存列
            $sales_table_data[1][1] = '<span>$' . ($sales_cal_result->last_balance ?? '') . '</span>';
            $sales_table_data[5][1] = '<span>支出</span>';
            $sales_table_data[$footer_start_line_num][1] = '<span>總支出：</span>';
            $sales_table_data[$footer_start_line_num + 2][1] = '<span>存入銀行</span>';
            $sales_table_data[$footer_start_line_num + 6][1] = '<span>早:$'. ($sales_income_detail['21'] ?? '') . '</span>';
            $sales_table_data[$footer_start_line_num + 7][1] = '<span>午:$'. ($sales_income_detail['22'] ?? '') . '</span>';
            $sales_table_data[$footer_start_line_num + 8][1] = '<span>晚:$'. ($sales_income_detail['23'] ?? '') . '</span>';

            //摘要列
            $sales_table_data[1][2] = '<span>主機：Z NO.<u>' . ($sales_cal_result->first_pos_no ?? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;') . '</u> $<u>'. ($sales_income_detail['12'] ?? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;') . '</u>(+)</span>';
            $sales_table_data[2][2] = '<span>副機：Z NO.<u>' . ($sales_cal_result->second_pos_no ?? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;') . '</u> $<u>'. ($sales_income_detail['14'] ?? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;') . '</u>(=)</span>';
            if(isset($sales_cal_result->difference) && $sales_cal_result->difference > 0){
                $sales_table_data[3][2] = '<span>差額 +' . ($sales_cal_result->difference ?? '') . '</span>';
            }else{
                $sales_table_data[3][2] = '<span>差額 ' . ($sales_cal_result->difference ?? '') . '</span>';
            }

            $sales_table_data[5][2] = '<span>明細：</span>';
            $sales_table_data[$footer_start_line_num][2] = '<span>附支出單據共<u>&nbsp;&nbsp;' . ($bill_count) .'&nbsp;&nbsp;</u>張</span>';
            $sales_table_data[$footer_start_line_num + 1][2] = '<span>往來蛋控：(' . (isset($sales_income_detail['73']) ? '慧霖' : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;') . ')分店來/取銀</span>';
            $sales_table_data[$footer_start_line_num + 2][2] = '<span>存入總公司(' . ($bank ?? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;') . ')銀行之金額</span>';
            $sales_table_data[$footer_start_line_num + 3][2] = '<span style="float:right;padding-right:30px;">八達通存款</span>';
            $sales_table_data[$footer_start_line_num + 4][2] = '<span style="float:right;padding-right:30px;">支付寶存款</span>';
            $sales_table_data[$footer_start_line_num + 5][2] = '<span style="float:right;padding-right:30px;">微信存款</span>';
            $sales_table_data[$footer_start_line_num + 6][2] = '<span>紙幣：</span>';
            $sales_table_data[$footer_start_line_num + 7][2] = '<span>硬幣：</span>';
            $sales_table_data[$footer_start_line_num + 8][2] = '<span>總數：</span>';

            //收入列
            //收入
            $sales_table_data[2][3] = '<span>$' . ($sales_cal_result->income_sum ?? '') . '</span>';

            //支出列
            //支單總計
            $sales_table_data[$footer_start_line_num][4] = '<span>$' . ($sales_cal_result->bill_paid_sum ?? '') . '</span>';
            //慧霖取銀
            $sales_table_data[$footer_start_line_num + 1][4] = '<span>$' . ($sales_income_detail['73'] ?? '') . '</span>';
            //存入銀行
            $sales_table_data[$footer_start_line_num + 2][4] = '<span>$' . ($sales_income_detail['72'] ?? '') . '</span>';
            //八達通存款
            $sales_table_data[$footer_start_line_num + 3][4] = '<span>$' . ($sales_income_detail['31'] ?? '') . '</span>';
            //支付寶存款
            $sales_table_data[$footer_start_line_num + 4][4] = '<span>$' . ($sales_income_detail['32'] ?? '') . '</span>';
            //微信存款
            $sales_table_data[$footer_start_line_num + 5][4] = '<span>$' . ($sales_income_detail['33'] ?? '') . '</span>';

            $bill_outlay_num = $bill_start_line_num;
            foreach ($sales_bills as $bill){
                $sales_table_data[$bill_outlay_num][4] = '<span>$' . ($bill->outlay) . '</span>';
                $bill_outlay_num ++;
            }

            //餘額列
            $sales_table_data[$footer_start_line_num + 6][5] = '<span>$' . ($paper_money_sum) . '</span>';
            $sales_table_data[$footer_start_line_num + 7][5] = '<span>$' . ($coin_sum) . '</span>';
            $sales_table_data[$footer_start_line_num + 8][5] = '<span>$' . ($sales_cal_result->balance ?? '') . '</span>';

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
