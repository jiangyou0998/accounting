<?php

namespace App\Http\Controllers;


use App\Http\Requests\SalesDataChangeApplicationRequest;
use App\Models\SalesDataChangeApplication;
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
}
