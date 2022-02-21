<?php

namespace App\Http\Controllers;


use App\Http\Requests\SalesDataRequest;
use App\Models\FrontGroup;
use App\Models\FrontGroupHasUser;
use App\Models\SalesBill;
use App\Models\SalesCalResult;
use App\Models\SalesIncomeDetail;
use App\Models\SalesIncomeType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SalesDataController extends Controller
{
    public function index()
    {
        $sales_cal_result = SalesCalResult::getSalesCalResult();
        $last_balance = SalesCalResult::getLastBalance();
        $sales_cal_result_id = $sales_cal_result->id ?? 0;

        $sales_income_detail = SalesIncomeDetail::getSalesIncomeDetailArray($sales_cal_result_id);

        $bank = SalesIncomeDetail::getBank($sales_cal_result_id);
        $bills = SalesBill::getSalesBills()->pluck('outlay', 'bill_no')->toArray();
//        dump($bills);
        return view('sales_data.index', compact('sales_cal_result', 'last_balance', 'sales_income_detail', 'bank', 'bills'));
    }

    public function report(Request $request)
    {
        $date = $request->date ?? Carbon::now()->toDateString();
        $front_groups = FrontGroupHasUser::query()
            ->where('front_group_id', '!=' , 4)
            ->get()->mapToGroups(function ($item, $key) {
                //3 === $item['front_group_id'] 為餅店分組
                //80 !== $item['user_id'] ID80用戶為利東街, 暫時不計入餅店
                if(3 === $item['front_group_id'] && 80 !== $item['user_id']){
                    return [ 'bakery' => $item['user_id']];
                }else{
                    return [ 'other' => $item['user_id']];
                }
            })->toArray();
        $sale_summary = SalesCalResult::query()->with(['user', 'details'])->where('date', $date)->get();
        $sale_summary = $sale_summary->mapToGroups(function ($item, $key) use($front_groups){
//            $item->octopus = $item['detail']->where('type_no', 31)->first()->income ?? '0.00';
            if(in_array($item['shop_id'], $front_groups['bakery'])){
                return ['bakery' => $item];
            }else{
                return ['other' => $item];
            }
        });
//        dump($front_groups['other']);

//        dump($sale_summary->toArray());
        return view('sales_data.report', compact('sale_summary', 'date'));
    }

    public function redirect()
    {
        $user = Auth::user();
        if($user->can('operation') || $user->hasRole('SuperAdmin')){
            //營運、管理員跳轉report
            return redirect(route('sales_data.report'));
        }else if($user->can('shop')){
            //分店跳轉營業數輸入
            return redirect(route('sales_data'));
        }else{
            abort('403', '你沒有權限查看!');
        }
    }

    public function store(SalesDataRequest $request){

        // 数据库事务处理
        DB::transaction(function () use ($request) {
            $user = Auth::user();
            $shop_id = $user->id;
//        $results['']

            $deposit_no = SalesCalResult::getNewDepositNo();
            $last_balance = SalesCalResult::getLastBalance();
            $last_safe_balance = 0;
            $date = Carbon::now()->toDateString();

            $sales_cal_result = SalesCalResult::getSalesCalResult();

            if(is_null($sales_cal_result)){
                $sales_cal_result = new SalesCalResult();
                $sales_cal_result->shop_id = $shop_id;
                $sales_cal_result->deposit_no = $deposit_no;
                $sales_cal_result->date = $date;
            }

            $sales_cal_result->first_pos_no = $request->first_pos_no;
            $sales_cal_result->second_pos_no = $request->second_pos_no;
            $sales_cal_result->last_balance = $last_balance;
            $sales_cal_result->balance = $request->balance;
            $sales_cal_result->last_safe_balance = $last_safe_balance;
            $sales_cal_result->safe_balance = $request->safe_balance;
            $sales_cal_result->bill_paid_sum = $request->bill_paid_sum;
            $sales_cal_result->income_sum = $request->income_sum;
            $sales_cal_result->difference = $request->difference;

            if($sales_cal_result->save()){
                $sales_cal_result_id = $sales_cal_result->id;
            }

            $types = SalesIncomeType::all()->pluck('type_no','name')->toArray();

            //更新前先刪除數據
            SalesIncomeDetail::where('sales_cal_result_id', $sales_cal_result_id)->delete();
            foreach($request->inputs[0] as $name => $income){
                if(isset($types[$name]) && !is_null($income)){
                    $remark = null;
                    if( $name === 'deposit_in_bank'){
                        $remark = $request->deposit_bank;
                    }
                    $temp[] = [
                        'sales_cal_result_id' => $sales_cal_result_id,
                        'type_no' => $types[$name],
                        'income' => $income,
                        'remark' => $remark
                    ];
                }
            }

            DB::table('sales_income_details')->insert($temp);

            //支單寫入數據庫
            SalesBill::where('shop_id', $shop_id)->where('date', $date)->delete();
            foreach($request->bills as $bill){
                $sales_bill = new SalesBill();
                $sales_bill->sales_cal_result_id = $sales_cal_result_id;
                $sales_bill->shop_id = $shop_id;
                $sales_bill->date = $date;
                $sales_bill->bill_no = $bill['bill_no'];
                $sales_bill->outlay = $bill['outlay'];

                $sales_bill->save();
            }

//
//            dump($request->toArray());
//            dump($request->inputs[0]);
//            dump($temp);
//            dump($sales_cal_result_id);
//            dump($sales_cal_result);
        });


    }

    public function print(){

        $sales_cal_result = SalesCalResult::getSalesCalResult();
        $print_info = new Collection();
        $print_info->deposit_no = $sales_cal_result->deposit_no ?? '';
        $print_info->date = Carbon::parse($sales_cal_result->date)->isoFormat('YYYY年MM月DD日');
        $print_info->shop_name = Auth::user()->report_name;

        $sales_table_data = $this->getSalesTableData();
        return view('sales_data.print', compact('sales_table_data', 'print_info'));
    }

    //打印報表表格內容
    private function getSalesTableData()
    {
        $sales_cal_result = SalesCalResult::getSalesCalResult();
        $sales_cal_result_id = $sales_cal_result->id ?? 0;

        $sales_income_detail = SalesIncomeDetail::getSalesIncomeDetailArray($sales_cal_result_id);
        $bank = SalesIncomeDetail::getBank($sales_cal_result_id);

        $sales_bills = SalesBill::getSalesBills();
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
//存入銀行
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

        return $sales_table_data;
    }

}
