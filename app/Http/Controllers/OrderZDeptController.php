<?php

namespace App\Http\Controllers;


use App\Models\WorkshopGroup;
use App\Models\WorkshopProduct;
use App\Models\WorkshopSample;
use App\Models\WorkshopCartItem;
use App\Models\WorkshopCat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class OrderZDeptController extends Controller
{
    public function cart(Request $request)
    {
        $user = Auth::User();
//        dd(Auth::User());
//        $advance = 20;
        $dept = 'R';
        $shop = $user->id;
//        $advancePlusOne = $advance + 1;
        //送貨日期(格式:2020-09-14)
        $deli_date = $request->deli_date;
        //送貨日期的星期几（格式:从0（星期日）到6（星期六））
        $deliW = Carbon::parse($deli_date)->isoFormat('d');

//        $now = Carbon::now();
//        $deliDate = $now->add($advancePlusOne . 'day')->toDateString();
//        $week = $now->add($advancePlusOne . 'day')->dayOfWeek;

//        dd($week);

//        dd($deliDate);

        $items = WorkshopCartItem::getCartItems($shop, $dept, $deli_date);
        $cats = WorkshopCat::getCatsNotExpired($deli_date);
//        dump($deliDate);
//        dump(count($items));
        $sampleItems = new Collection();
        if(count($items) == 0 && $dept == 'R'){
            $sampleItems = WorkshopSample::getRegularOrderItems($shop,$deliW);
        }

        foreach ($sampleItems as $sampleItem){
            $sampleItem->haveoutdate = false;
            //後勤落單
            if($sampleItem->phase <= 0){
                $sampleItem->haveoutdate = true;
            }

            $canOrderTime = explode(",", $sampleItem->canordertime);
            //送貨日期不在可下單日期時
            if (!in_array($deliW, $canOrderTime)) {
                $sampleItem->haveoutdate = true;
            }

//            dump($sampleItem);
        }

//        $orderInfos = [
//            'date' => '2020-09-27'
//        ];

        $orderInfos = new Collection();
        $orderInfos->date = $deli_date;
        $orderInfos->shop_name = $user->txt_name;
        $orderInfos->dept = $dept;
        $orderInfos->deli_date = $deli_date;

        return view('order.cart', compact('items', 'cats','sampleItems', 'orderInfos'));
    }

    public function showGroup($catid){
        $groups = WorkshopGroup::where('cat_id',$catid)->get();

        return view('order.cart_group',compact('groups'))->render();
    }

    public function showProduct($groupid){
        $products = WorkshopProduct::where('group_id',$groupid)->where('status','!=',4)->get();

        return view('order.cart_product',compact('products'))->render();
    }
}
