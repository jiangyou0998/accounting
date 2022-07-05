<?php

namespace App\Http\Controllers;


use App\Http\Requests\SalesDataChangeApplicationRequest;
use App\Models\SalesDataChangeApplication;
use App\Models\ShopGroup;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalesDataChangeApplicationController extends Controller
{
    public function index()
    {
        $datas = SalesDataChangeApplication::query()
            //查詢處理日期為今天的
            ->where(function ($query){
                return $query
                    ->where('shop_id', Auth::id())
                    ->whereDate('handle_date', now());
            })
            //查詢申請中
            ->orWhere(function ($query){
                return $query
                    ->where('shop_id', Auth::id())
                    ->where('status', SalesDataChangeApplication::STATUS_APPLYING);
            })
            ->latest('date')
            ->get();

        return view('sales_data.change_application.index', compact('datas'));
    }

    //提交修改申請
    public function store(SalesDataChangeApplicationRequest $request){

        $date = $request->date;

        $shop_id = Auth::id();

        SalesDataChangeApplication::applicationSubmit($date, $shop_id);

    }

    //權限為operation的同事可以審批
    public function apply_index()
    {
        //申請中數據
        $applying_datas = SalesDataChangeApplication::query()
            ->where('status', SalesDataChangeApplication::STATUS_APPLYING)
            ->latest('date')
            ->get();

        //今日處理的數據
        $today_handled_datas = SalesDataChangeApplication::query()
            ->where('status', '!=', SalesDataChangeApplication::STATUS_APPLYING)
            ->whereDate('handle_date', now())
            ->latest('date')
            ->get();

//        dump($today_handled_datas->toArray());

        $shop_names = User::getShopsByShopGroup(ShopGroup::CURRENT_SHOP_ID)->pluck('report_name', 'id')->toArray();

        return view('sales_data.change_application.apply', compact(
            'applying_datas',
            'today_handled_datas',
            'shop_names'));
    }

    public function apply(Request $request)
    {
        $applicationModel = SalesDataChangeApplication::find($request->id);

        //狀態 0-申請中,1-同意,2-不同意
        $applicationModel->status = $request->status;
        //授權用戶
        $applicationModel->handle_user = Auth::id();
        //可操作日期
        $applicationModel->handle_date = Carbon::now()->toDateString();

        $applicationModel->save();

    }

}
