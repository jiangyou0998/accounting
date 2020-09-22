<?php

namespace App\Http\Controllers;


use App\Models\Menu;
use App\Models\Order;
use App\User;
use Carbon\Carbon;

class OrderController extends Controller
{


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $menus = Menu::with('allChildrenMenu')->get();
        return view('order.index', compact('menus'));
    }

    public function select_day()
    {
        $menus = Menu::with('allChildrenMenu')->get();

        $isSun = $this->isSunday();

        $dayArray = $this->getDayArray();

        $shops = User::getRyoyuBakeryShops();
//        dump($dayArray);


        return view('order.select_day', compact('menus', 'dayArray', 'isSun','shops'));
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

}
