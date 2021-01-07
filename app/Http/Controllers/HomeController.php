<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use App\Models\WorkshopCartItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
////        $this->middleware('auth');
//    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $notices = Notice::getNoticesForHome();

        foreach ($notices as &$notice){
            $notice->isNew = false;
            $modify_date = Carbon::parse($notice->modify_date);
            $now = Carbon::now();

            //七日內是新
            if($now->diffInDays($modify_date,false) > -7){
                $notice->isNew = true;
            }
        }
        $dept_names = Notice::getDeptName();

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


//        dump($notices);
        return view('home.home',compact('notices','dept_names', 'countArr'));
    }
}
