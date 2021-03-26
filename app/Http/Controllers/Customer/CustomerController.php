<?php

namespace App\Http\Controllers\Customer;


use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ShopGroup;
use App\Models\WorkshopCartItem;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;


class CustomerController extends Controller
{

    public function select_old_order(Request $request)
    {
        $shop_group_id = $request->shop_group_id;
        //獲取當前分組名稱
        $shop_group_name = ShopGroup::find($shop_group_id)->name;

        //獲取當前分組所有分店
        $shops = User::getShopsByShopGroup($shop_group_id);

        $shopids = $shops->pluck('id');
        $shop_names = $shops->pluck('report_name','id')->toArray();

        $start_date = $request->start;
        if($start_date == ''){
            $start_date = Carbon::now()->toDateString();
        }

        $end_date = $request->end;
        if($end_date == ''){
            $end_date = Carbon::parse($start_date)->addDay(10)->toDateString();
        }

        $dept = $request->dept;

        $items = WorkshopCartItem::getRegularOrderCount($shopids,$start_date,$end_date,$dept);
//        dump($shops->toArray());
//        dump($shops->pluck('id'));

        $countArr = array();

        if($end_date >= $start_date){
            $start = Carbon::parse($start_date);
            $end = Carbon::parse($end_date);
            $time = $start;
            while($end->gte($time)) {
                foreach ($shopids as $shopid){
                    $countArr[$time->toDateString()][$shopid] = 0;
                }
                $time = $time->addDay();
            }
        }

        foreach ($items as $item){
            $countArr[$item->deli_date][$item->user_id] = $item->count;
        }

        return view('customer.order.select_order.index', compact('countArr','shop_names', 'shop_group_name'));
    }

    //選擇外客分組
    public function select_customer_group()
    {
        $shop_groups = ShopGroup::getCustomerGroup();
//        dd($shop_groups);

        return view('customer.select_group',compact('shop_groups'));
    }


}
