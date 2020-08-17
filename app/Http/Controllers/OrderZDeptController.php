<?php

namespace App\Http\Controllers;

use App\Models\RegularOrder;
use App\Models\TblOrderSample;
use App\Models\TblOrderZCat;
use App\Models\TblOrderZDept;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class OrderZDeptController extends Controller
{
    public function cart()
    {
        $user = Auth::User();
//        dd(Auth::User());
        $advance = 20;
        $dept = 'R';
        $shop = $user->id;
        $advancePlusOne = $advance + 1;
        $now = Carbon::now();
        $deliDate = $now->add($advancePlusOne . 'day')->toDateString();
        $week = $now->add($advancePlusOne . 'day')->dayOfWeek;

//        dd($week);

//        dd($deliDate);

        $items = TblOrderZDept::getCartItems($shop, $dept, $advancePlusOne);
        $cats = TblOrderZCat::getCatsNotExpired($deliDate);
//        dump($deliDate);
//        dump(count($items));
        $sampleItems = new Collection();
        if(count($items) == 0 && $dept == 'R'){
            $sampleItems = TblOrderSample::getRegularOrderItems($shop,$week);
        }

//        $orderInfos = [
//            'date' => '2020-09-27'
//        ];

        $orderInfos = new Collection();
        $orderInfos->date = $deliDate;
        $orderInfos->shop_name = $user->txt_name;
        $orderInfos->dept = $dept;
        $orderInfos->deli_date = $deliDate;

        return view('order.cart', compact('items', 'cats','sampleItems', 'orderInfos'));
    }
}
