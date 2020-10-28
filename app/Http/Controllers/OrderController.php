<?php

namespace App\Http\Controllers;


use App\Models\Menu;
use App\Models\Order;
use App\Models\WorkshopCartItem;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;


class OrderController extends Controller
{


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('order.index');
    }

    public function select_day()
    {
        $isSun = $this->isSunday();

        $dayArray = $this->getDayArray();

        $shops = User::getRyoyuBakeryShops();
//        dump($dayArray);


        return view('order.select_day', compact('dayArray', 'isSun','shops'));
    }

    public function select_old_order()
    {
        $isSun = $this->isSunday();

        $dayArray = $this->getDayArray();

        $shops = User::getRyoyuBakeryShops();
//        dump($dayArray);


        return view('order.select_old_order', compact('dayArray', 'isSun','shops'));
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
        $shops = User::getRyoyuBakeryShops();

        return view('order.deli.select_deli',compact('shops'));
    }

    public function regular_order()
    {
        $shops = User::getRyoyuBakeryShops();

        $shopids = $shops->pluck('id');
        $shop_names = $shops->pluck('report_name','id')->toArray();


        $start_date = '2020-11-01';
        $end_date = '2020-11-30';
        $items = WorkshopCartItem::getRegularOrderCount($shopids,$start_date,$end_date);
//        dump($shops->toArray());
//        dump($shops->pluck('id'));

        $countArr = array();

        if($end_date > $start_date){
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

//        dump($countArr);
//        dump($items->toArray());
//        dump($shop_names);
        return view('order.regular.index',compact('countArr','shop_names'));
    }

}
