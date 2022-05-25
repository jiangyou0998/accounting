<?php

namespace App\Http\Controllers;


use App\Http\Requests\SalesDataRequest;
use App\Http\Traits\SalesDataTableTraits;
use App\Models\FrontGroupHasUser;
use App\Models\SalesBill;
use App\Models\SalesCalResult;
use App\Models\SalesDataChangeApplication;
use App\Models\SalesIncomeDetail;
use App\Models\SalesIncomeType;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SalesDataController extends Controller
{
    use SalesDataTableTraits;

    public function index(Request $request)
    {
        $date = getRequestDateOrNow($request->date);

//        dump($special_dates->toArray());
        $this->checkEditable($date);

        $sales_cal_result = SalesCalResult::getSalesCalResult($date);
        $last_balance = SalesCalResult::getLastBalance($date);
        $last_safe_balance = SalesCalResult::getLastSafeBalance($date);
        $sales_cal_result_id = $sales_cal_result->id ?? 0;

        $sales_income_detail = SalesIncomeDetail::getSalesIncomeDetailArray($sales_cal_result_id);

        $bank = SalesIncomeDetail::getBank($sales_cal_result_id);
        $bills = SalesBill::getSalesBills($date)->pluck('outlay', 'bill_no')->toArray();
//        dump($bills);
        return view('sales_data.index', compact('sales_cal_result', 'last_balance', 'last_safe_balance', 'sales_income_detail', 'bank', 'bills', 'date'));
    }

    public function operation_index(Request $request)
    {
        return view('sales_data.operation_index');
    }

    //手機顯示營業數頁面
    public function report(Request $request)
    {
        $date = $request->date ?? Carbon::now()->toDateString();
        $date_and_week = Carbon::parse($date)->isoFormat('YYYY/MM/DD(dd)');
        $front_groups = FrontGroupHasUser::query()
            //不要後勤分組
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
        //2022-05-05 按shop_id排序
        $sale_summary = SalesCalResult::query()->with(['user', 'details'])->where('date', $date)->get()->sortBy('shop_id');
        $sale_summary = $sale_summary->mapToGroups(function ($item, $key) use($front_groups){
//            $item->octopus = $item['detail']->where('type_no', 31)->first()->income ?? '0.00';
            if(in_array($item['shop_id'], $front_groups['bakery'])){
                return ['bakery' => $item];
            }else{
                return ['other' => $item];
            }
        });
//        dump($front_groups);

        $day_income = SalesCalResult::getShopIdAndTotalIncome($date, 'day');
        $shop_names = User::getShopsByShopGroup(1)->pluck('report_name', 'id')->toArray();

        // 混合型/飯堂總數
        $sale_summary['other_total'] = 0;
        $sale_summary['other_month_total'] = 0;
        $sale_summary['other_last_month_total'] = 0;
        // 餅店總數
        $sale_summary['bakery_total'] = 0;
        $sale_summary['bakery_month_total'] = 0;
        $sale_summary['bakery_last_month_total'] = 0;
        // 全部總數
        $sale_summary['total'] = 0;
        $sale_summary['month_total'] = 0;
        $sale_summary['last_month_total'] = 0;

        // 計算 混合型/飯堂 總數
        if(isset($sale_summary['other'])){
            $sale_summary['other_total'] = $sale_summary['other']->sum('income_sum');
        }

        // 計算 餅店 總數
        if(isset($sale_summary['bakery'])){
            $sale_summary['bakery_total'] = $sale_summary['bakery']->sum('income_sum');
        }

        // 計算所有總數
        $sale_summary['total'] = $sale_summary['other_total'] + $sale_summary['bakery_total'];

        $total_income = SalesCalResult::getShopIdAndTotalIncome($date, 'month');

        foreach ($total_income as $shop_id => $total){
            if(in_array($shop_id, $front_groups['other'])){
                $sale_summary['other_month_total'] += $total;
            }else if(in_array($shop_id, $front_groups['bakery'])){
                $sale_summary['bakery_month_total'] += $total;
            }
            $sale_summary['month_total'] += $total;
        }

        //2022-04-19 新增獲取上個月合計
        $last_month_total_income = SalesCalResult::getShopIdAndLastMonthTotalAtSameDay($date);

        foreach ($last_month_total_income as $shop_id => $total){
            if(in_array($shop_id, $front_groups['other'])){
                $sale_summary['other_last_month_total'] += $total;
            }else if(in_array($shop_id, $front_groups['bakery'])){
                $sale_summary['bakery_last_month_total'] += $total;
            }
            $sale_summary['last_month_total'] += $total;
        }

        //2022-05-19 新增獲取時節數
        $seasonal_income = SalesCalResult::getShopIdAndSeasonalIncome($date);


//        dump($total_income);
//        dump($sale_summary->toArray());

        return view('sales_data.report', compact(
            'sale_summary',
            'total_income',
            'day_income',
            'seasonal_income',
            'last_month_total_income',
            'date',
            'date_and_week',
            'front_groups',
            'shop_names')
        );
    }

    //根據權限跳轉頁面
    public function redirect()
    {
        $user = Auth::user();
        if($user->can('operation') || $user->hasRole('SuperAdmin')){
            //營運、管理員跳轉report
            return redirect(route('sales_data.operation_index'));
        }else if($user->can('shop')){
            //分店跳轉營業數輸入
            return redirect(route('sales_data'));
        }else{
            abort('403', '你沒有權限查看!');
        }
    }

    //保存每日營業數
    public function store(SalesDataRequest $request){

        $date = $request->date ?? Carbon::now();
        $this->checkEditable($date);

        // 数据库事务处理
        DB::transaction(function () use ($request, $date) {

            $user = Auth::user();
            $shop_id = $user->id;

            $deposit_no = SalesCalResult::getNewDepositNo($date);
            $last_balance = SalesCalResult::getLastBalance($date);
            $last_safe_balance = SalesCalResult::getLastSafeBalance($date);

            $sales_cal_result = SalesCalResult::getSalesCalResult($date);

            if(is_null($sales_cal_result)){
                $sales_cal_result = new SalesCalResult();
                $sales_cal_result->shop_id = $shop_id;
                $sales_cal_result->deposit_no = $deposit_no;
                $sales_cal_result->date = $date;
            }

            //主機NO.
            $sales_cal_result->first_pos_no = $request->first_pos_no;
            //副機NO.
            $sales_cal_result->second_pos_no = $request->second_pos_no;
            //承上結存
            $sales_cal_result->last_balance = $last_balance;
            //當日結存(全鋪餘款)
            $sales_cal_result->balance = $request->balance;
            //夾萬承上結存
            $sales_cal_result->last_safe_balance = $last_safe_balance;
            //當日夾萬結存(夾萬結餘)
            $sales_cal_result->safe_balance = $request->safe_balance;
            //支單總額
            $sales_cal_result->bill_paid_sum = $request->bill_paid_sum;
            //收入
            $sales_cal_result->income_sum = $request->income_sum;
            //差額
            $sales_cal_result->difference = $request->difference;

            if($sales_cal_result->save()){
                $sales_cal_result_id = $sales_cal_result->id;
            }

            $types = SalesIncomeType::all()->pluck('type_no','name')->toArray();

            //更新前先刪除數據
            SalesIncomeDetail::where('sales_cal_result_id', $sales_cal_result_id)->delete();

            //2022-03-31 慧霖取銀可以輸入負數
            if(isset($request->kelly_out)){
                $temp[] = [
                    'sales_cal_result_id' => $sales_cal_result_id,
                    'type_no' => $types['kelly_out'],
                    'income' => $request->kelly_out,
                    'remark' => null
                ];
            }

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

            //2022-03-25 如全部未填寫,則只清空所有details
            if(isset($temp)){
                DB::table('sales_income_details')->insert($temp);
            }

            //支單寫入數據庫
            SalesBill::where('shop_id', $shop_id)->whereDate('date', $date)->delete();

            if(isset($request->bills)){
                foreach($request->bills as $bill){
                    $sales_bill = new SalesBill();
                    $sales_bill->sales_cal_result_id = $sales_cal_result_id;
                    $sales_bill->shop_id = $shop_id;
                    $sales_bill->date = $date;
                    $sales_bill->bill_no = $bill['bill_no'];
                    $sales_bill->outlay = $bill['outlay'];

                    $sales_bill->save();
                }
            }

//            dump($request->toArray());
//            dump($request->inputs[0]);
//            dump($temp);
//            dump($sales_cal_result_id);
//            dump($sales_cal_result);
        });


    }

    //打印用表格(分店查看)
    //分店只能查看當日數據
    public function print(Request $request){

        $date = getRequestDateOrNow($request->date);
        $start_date = $end_date = $date;
        $id = Auth::user()->id;
        $ids = array($id);

        $all_sales_table_data = $this->getAllSalesTableData($start_date, $end_date, $ids);

        if(count($all_sales_table_data) === 0){
            return '<h1>未找到數據!</h1>';
        }

        return view('sales_data.print', compact('all_sales_table_data'));
    }

    //檢查編輯權限
    private function checkEditable($date)
    {
        //判斷權限
        if (Carbon::parse($date)->gt(Carbon::now())){
            abort(403,'不允許修改今天後的營業數');
        }

        //如非當日,必須要先申請修改權限
        if (! Carbon::parse($date)->isToday()){
            $special_date = SalesDataChangeApplication::query()
                ->where('shop_id', Auth::id())
                ->where('date', $date)
                ->where('handle_date', Carbon::now()->toDateString())
                ->where('status', SalesDataChangeApplication::STATUS_APPROVED)
                ->first();

            if (!isset($special_date)){
                abort(403,'請先申請修改權限');
            }
        }

        return true;
    }

}
