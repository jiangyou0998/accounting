<?php

namespace App\Http\Controllers;


use App\Http\Requests\SalesCalResultRequest;
use App\Models\SalesCalResult;
use App\Models\SalesDataChangeApplication;
use App\Models\ShopGroup;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class SalesCalResultController extends Controller
{
    public function create()
    {
        $shops = User::getShopsByShopGroup(ShopGroup::CURRENT_SHOP_ID);

        return view('sales_data.sales_cal_results.create', compact('shops'));
    }

    public function check(SalesCalResultRequest $request)
    {
        $shop_id = $request->shop_id;
        $date = $request->date;

        $date_carbon = Carbon::parse($date);
        $start_of_month = $date_carbon->startOfMonth()->toDateString();
        $end_of_month = $date_carbon->endOfMonth()->toDateString();

        $result = SalesCalResult::query()
            ->with('user')
            ->where('shop_id', $shop_id)
            ->whereBetween('date', [$start_of_month, $end_of_month])
            ->get();

        //查詢不到當日數據,才可以新增
        $can_create = SalesCalResult::query()
            ->where('shop_id', $shop_id)
            ->whereDate('date', $date)
            ->count();

        $data = [
            'status'                =>  'success',
            'count'                 =>  $result->count(),
            'msg'                   =>  '查詢成功!',
            'result'                =>  $result,
            'can_create'            =>  $can_create,
        ];

        return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

    }

    public function store(SalesCalResultRequest $request){

        $shop_id = $request->shop_id;
        $date = $request->date;

        //查詢不到當日數據,才可以新增
        $can_create = SalesCalResult::query()
            ->where('shop_id', $shop_id)
            ->whereDate('date', $date)
            ->count();

        if ($can_create === 0){
            // 数据库事务处理
            return DB::transaction(function () use ($shop_id, $date) {
                $end_of_month = Carbon::parse($date)->endOfMonth();
                //所選日子之後deposit_no + 1(到月底)
                DB::table('sales_cal_results')
                    ->where('shop_id', $shop_id)
                    ->whereDate('date', '>',  $date)
                    ->whereDate('date', '<=', $end_of_month)
                    ->increment('deposit_no');

                //新增空白營業數數據
                $sales_cal_result = new SalesCalResult();
                $deposit_no = SalesCalResult::getNewDepositNo($date, $shop_id);
                $sales_cal_result->shop_id = $shop_id;
                $sales_cal_result->date = $date;
                $sales_cal_result->deposit_no = $deposit_no;
                $sales_cal_result->balance = 0;
                $sales_cal_result->last_balance = 0;
                $sales_cal_result->income_sum = 0;
                $sales_cal_result->difference = 0;
                $sales_cal_result->save();

                $application = new SalesDataChangeApplication();
                $application->shop_id = $shop_id;
                $application->handle_user = Auth::id();
                $application->handle_date = Carbon::now()->toDateString();
                $application->status = SalesDataChangeApplication::STATUS_APPROVED;

                //提交新增日期修改申請
                $apply_date_model = clone $application;
                $apply_date_model->date = $date;
                $apply_date_model->save();

                $next_sales_data = SalesCalResult::query()
                    ->where('deposit_no', $deposit_no + 1)
                    ->where('shop_id', $shop_id)
                    ->first();

                //存在下一條數據, 並且不是今天的數據, 同時提交修改申請
                if( (isset($next_sales_data->date)) && (! Carbon::parse($next_sales_data->date)->isToday()) ){
                    $apply_next_date_model = clone $application;
                    $apply_next_date_model->date = $next_sales_data->date;
                    $apply_next_date_model->save();
                }

                $data = [
                    'status'                =>  'success',
                    'msg'                   =>  '添加成功!',
                ];

                return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            });
        }else{
            $data = [
                'status'                =>  'error',
                'msg'                   =>  '當天已存在營業數據!',
            ];

            return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
    }
}
