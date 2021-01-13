<?php

namespace App\Http\Controllers;


use App\Models\Order;
use App\Models\WorkshopCartItem;
use App\Models\WorkshopOrderSample;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;


class OrderController extends Controller
{


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //最近下單數量
        $user = Auth::user();
        $countArr = array();
        if($user && $user->can('shop')){

            $shopids = [$user->id];

            //首頁顯示最近幾日下單
            $showDayNum = 9;

            $start_date = Carbon::now()->toDateString();
//            $start_date = '2020-12-01';

            $end_date = Carbon::parse($start_date)->addDay($showDayNum - 1)->toDateString();

            $items = WorkshopCartItem::getRegularOrderCount($shopids,$start_date,$end_date,null);

            for ($i = 0; $i < $showDayNum; $i++) {
                $day = Carbon::parse($start_date)->addDay($i)->toDateString();
                $countArr[$day] = '未下單';
            }

            foreach ($items as $item){
//                $day = Carbon::parse($item->deli_date)->isoFormat('MM-DD(dd)');
                $day = $item->deli_date;
                $countArr[$day] = $item->count;
            }

//            dump($items->toArray());
//            dump($countArr);
        }

        return view('order.index' ,compact('countArr'));
    }

    public function select_day()
    {
        $isSun = $this->isSunday();

        $dayArray = $this->getDayArray();

        $shops = User::getKingBakeryShops();
//        dump($dayArray);


        return view('order.select_day', compact('dayArray', 'isSun','shops'));
    }

    public function select_old_order(Request $request)
    {
        $shops = User::getKingBakeryShops();

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

        return view('order.select_order.index', compact('countArr','shop_names'));
    }

    public function select_rb_old_order(Request $request)
    {
        $shops = User::getRyoyuBakeryShops();

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

        return view('rb.order.select_order.index', compact('countArr','shop_names'));
    }

    public static function getDayArray($advDays = 14)
    {
        for ($count = 1; $count <= $advDays; $count++) {
            $desc = "特別安排";
            $date = Carbon::now()->addDays($count);
            $dayStr = $date->isoFormat('M月DD日（dd）');
            //收貨時間
            $deli_date = $date->isoFormat('YYYY-MM-DD');

            switch ($count) {
                case 1:
                    $desc = "一日後";
                    break;
                case 2:
                    $desc = "兩日後";
                    break;
                case 3:
                    $desc = "三日後";
                    break;
                case 4:
                    $desc = "四日後";
                    break;
                case 5:
                    $desc = "五日後";
                    break;
                default:
                    $desc = "特別安排";
                    break;
            }
            $tempArray = [];
            $tempArray['dayStr'] = $dayStr;
            $tempArray['desc'] = $desc;
            $tempArray['deli_date'] = $deli_date;
            $dayArray[$count] = $tempArray;

        }

        return $dayArray;
    }

    //週日有些不能下單
    function isSunday()
    {
        $isSun = false;

        if (date("D") == "Sun")
            $isSun = true;

        return $isSun;
    }

    //送貨單
    public function order_deli(Request $request)
    {
        $now = Carbon::now();
        //如果URL沒有送貨日期,使用當日日期
        if(isset($request->deli_date)){
            $deli_date = $request->deli_date;
        }else{
            $deli_date = $now->toDateString();
        }

        //根據權限獲取商店id
        $shop = User::getShopId($request->shop);

        //送貨單詳細數據
        $details = WorkshopCartItem::getDeliDetail($deli_date,$shop);
        //合計數據
        $totals = WorkshopCartItem::getDeliTotal($deli_date,$shop);

//        dump($details->toArray());
//        dump($totals->toArray());

        //頁面顯示數據
        $infos = new Collection();
        $infos->deli_date = $deli_date;
        $infos->shop = $shop;
        $infos->shop_name = User::find($shop)->txt_name;
        $infos->now = $now->toDateTimeString();
//        dump($infos);

        return view('order.deli.index',compact('details','totals','infos'));
    }

    //工場,營運選擇送貨單
    public function select_deli()
    {
        $shops = User::getKingBakeryShops();

        return view('order.deli.select_deli',compact('shops'));
    }

    //查看方包下單
    public function regular_order(Request $request)
    {
        $shops = User::getKingBakeryShops();

        $shopids = $shops->pluck('id');
        $shop_names = $shops->pluck('report_name','id')->toArray();

        $start_date = $request->start;
        $end_date = $request->end;
        $dept = 'D';
        $items = WorkshopCartItem::getRegularOrderCount($shopids,$start_date,$end_date,$dept);
//        dump($shops->toArray());
//        dump($shops->pluck('id'));

//        dump($items->toArray());
//        dump($shop_names);
//        $counts = WorkshopCartItem::getRegularOrderCount($shops,$start_date,$end_date,$dept);

        $counts = $items;

        $counts = $counts->mapToGroups(function ($item, $key) {
            return [$item['user_id'] => $item['deli_date']];
        });

        $sampleItems = WorkshopOrderSample::getSampleByDept($dept);

//        dump($sampleItems->toArray());

        foreach ($sampleItems as $sampleItem){
            $sampledate =  $sampleItem['sampledate'];
            $sampledateArr = explode(',',$sampledate);

            foreach ($sampledateArr as $value){
                $sampleArr[$sampleItem['user_id']][$value] = $sampleItem->toArray();
            }

        }
//        dump($sampleArr);
//        dump(isset($sampleArr[44][1]));
////        dump($sampleItems->toArray());
//        dump($counts->toArray());

        $countArr = array();
        $insertArr = array();
        if($end_date >= $start_date){
            $start = Carbon::parse($start_date);
            $end = Carbon::parse($end_date);
            $now = Carbon::now()->toDateTimeString();
            $time = $start;
            while($end->gte($time)) {
                foreach ($shopids as $shopid){
                    $deli_date =$time->toDateString();
                    $week = $time->isoFormat('d');
                    $countArr[$deli_date][$shopid] = 0;

                    //已經下單,false未下單,true已下單
                    $is_order = false;

                    if(isset($counts->toArray()[$shopid])
                        && in_array($deli_date,$counts->toArray()[$shopid])){
                        $is_order = true;
                    }

                    if (isset($sampleArr[$shopid][$week])
                        && !$is_order){
                        $insertArr[] = [
                            'user_id' => $shopid,
                            'product_id' => $sampleArr[$shopid][$week]['product_id'],
                            'qty' => $sampleArr[$shopid][$week]['qty'],
                            'dept' => $dept,
                            'ip' => $request->ip(),
                            'status' => 1,
                            'deli_date' => $deli_date,
                            'order_date' => $now,
                            'insert_date' => $now,

                        ];
                    }
                }
                $time = $time->addDay();
            }
        }

        foreach ($items as $item){
            $countArr[$item->deli_date][$item->user_id] = $item->count;
        }


        dump($countArr);
        var_dump($insertArr);


        return view('order.regular.index',compact('countArr','shop_names'));
    }

}
