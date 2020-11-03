<?php

namespace App\Http\Controllers;


use App\Models\Order;
use App\Models\WorkshopCartItem;
use App\Models\WorkshopOrderSample;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class RegularOrderController extends Controller
{


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
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
            $end_date = Carbon::parse($start_date)->addDay(7)->toDateString();
        }
        $dept = 'D';
        $items = WorkshopCartItem::getRegularOrderCount($shopids,$start_date,$end_date,$dept);

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
                $sampleArr[$sampleItem['user_id']][$value][] = $sampleItem->toArray();
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
                        foreach ($sampleArr[$shopid][$week] as $temp){
                            $insertArr[] = [
                                'user_id' => $shopid,
                                'product_id' => $temp['product_id'],
                                'qty' => $temp['qty'],
                                'dept' => $dept,
                                'ip' => $request->ip(),
                                'status' => 1,
                                'deli_date' => $deli_date,
                                'order_date' => $now,
                                'insert_date' => $now,

                            ];
                        }
                    }
                }
                $time = $time->addDay();
            }
        }

        foreach ($items as $item){
            $countArr[$item->deli_date][$item->user_id] = $item->count;
        }


//        dump($countArr);
//        var_dump($insertArr);


        return view('order.regular.index',compact('countArr','shop_names'));
    }

    public function store(Request $request){

        $shops = User::getRyoyuBakeryShops();

        $shopids = $shops->pluck('id');

        $start_date = $request->start;
        $end_date = $request->end;
        $dept = 'D';
        $items = WorkshopCartItem::getRegularOrderCount($shopids,$start_date,$end_date,$dept);

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
                $sampleArr[$sampleItem['user_id']][$value][] = $sampleItem->toArray();
            }

        }

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

                    //已經下單,false未下單,true已下單
                    $is_order = false;

                    if(isset($counts->toArray()[$shopid])
                        && in_array($deli_date,$counts->toArray()[$shopid])){
                        $is_order = true;
                    }

                    if (isset($sampleArr[$shopid][$week])
                        && !$is_order){
                        foreach ($sampleArr[$shopid][$week] as $temp){
                            $insertArr[] = [
                                'user_id' => $shopid,
                                'product_id' => $temp['product_id'],
                                'qty' => $temp['qty'],
                                'dept' => $dept,
                                'ip' => $request->ip(),
                                'status' => 1,
                                'deli_date' => $deli_date,
                                'order_date' => $now,
                                'insert_date' => $now,

                            ];
                        }
                    }
                }
                $time = $time->addDay();
            }
        }

//        dump($counts);
//        dump($insertArr);
//        $cartitemModel = new WorkshopCartItem();
//        $cartitemModel->create($insertArr);

        DB::table('workshop_cart_items')->insert($insertArr);

    }

}
