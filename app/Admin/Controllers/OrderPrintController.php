<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\WorkshopCartItem;
use App\Models\WorkshopCat;
use App\Models\WorkshopCheck;
use App\Models\WorkshopGroup;
use App\Models\WorkshopProduct;
use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;


class OrderPrintController extends Controller
{

//    public function print(Request $request)
//    {
//        $cat_id = $request->cat_id;
//        $deli_date = $request->deli_date;
//
//        $shops = User::getKingBakeryShops();
//
//        $cartitemModel = new WorkshopCartItem();
//        $datas = $cartitemModel
//            ->select('workshop_products.product_no as 編號' )
//            ->addSelect('workshop_products.product_name as 名稱')
//            ->addSelect(DB::raw('ROUND(SUM(ifnull(workshop_cart_items.qty_received,workshop_cart_items.qty)) , 0) as Total'));
//
//        $totals = $cartitemModel;
//
//        foreach ($shops as $shop){
////                $sql = "sum(case when workshop_cart_items.user_id = '$shop->id' then workshop_cart_items.qty else 0 end) as '$shop->chr_report_name'";
////                dump($sql);
//            $sql = "ROUND(sum(case when (workshop_cart_items.user_id = '$shop->id' and workshop_cart_items.dept != 'B') then ifnull(workshop_cart_items.qty_received,workshop_cart_items.qty) else 0 end),0) as '$shop->report_name'";
//            $datas = $datas
//                ->addSelect(DB::raw($sql));
//            $totals = $totals
//                ->addSelect(DB::raw($sql));
//
//            $sql = "ROUND(sum(case when (workshop_cart_items.user_id = '$shop->id' and workshop_cart_items.dept = 'B') then ifnull(workshop_cart_items.qty_received,workshop_cart_items.qty) else 0 end),0) as '$shop->report_name"."2'";
//            $datas = $datas
//                ->addSelect(DB::raw($sql));
//            $totals = $totals
//                ->addSelect(DB::raw($sql));
//        }
//
//        $datas = $datas
//            ->leftJoin('workshop_products', 'workshop_products.id', '=', 'workshop_cart_items.product_id')
//            ->leftJoin('workshop_groups', 'workshop_products.group_id', '=', 'workshop_groups.id')
//            ->leftJoin('workshop_cats', 'workshop_groups.cat_id', '=', 'workshop_cats.id')
//            ->leftJoin('users', 'users.id', '=', 'workshop_cart_items.user_id')
//            ->where('users.type', '=', 2)
//            ->where('workshop_cart_items.status', '<>', 4)
//            ->where('workshop_cats.id',$cat_id)
//            ->where('workshop_cart_items.deli_date', $deli_date)
//            ->groupBy('workshop_products.id')
//            ->orderBy('workshop_products.product_no')
//            ->orderBy('workshop_groups.id')
//            ->get();
//
////        dump($datas->toArray());
//        $totals = $totals
//            ->leftJoin('workshop_products', 'workshop_products.id', '=', 'workshop_cart_items.product_id')
//            ->leftJoin('workshop_groups', 'workshop_products.group_id', '=', 'workshop_groups.id')
//            ->leftJoin('workshop_cats', 'workshop_groups.cat_id', '=', 'workshop_cats.id')
//            ->leftJoin('users', 'users.id', '=', 'workshop_cart_items.user_id')
//            ->where('users.type', '=', 2)
//            ->where('workshop_cart_items.status', '<>', 4)
//            ->where('workshop_cats.id',$cat_id)
//            ->where('workshop_cart_items.deli_date', $deli_date)
//            ->first();
//
//        $heading_shops = array();
////        dump($totals->toArray());
//        foreach ($totals->toArray() as $key=>$total){
////            dump($total);
//            if($total != '0'){
//                $heading_shops[] = $key;
//            }
//        }
////        dump(in_array('奧海城2',$heading_shops));
//
//        $headings = [];
//        if($datas->first()){
//            $headings = $datas->first()->toArray();
//        }
//
////        dump($datas->toArray());
//        $checkInfos = new Collection();
//        $checkInfos->title = WorkshopCat::find($cat_id)->cat_name;
//        $checkInfos->deli_date = $deli_date;
//
//        return view('admin.order_print.index',compact('datas' ,'headings', 'heading_shops','checkInfos'));
//    }

    public function print(Request $request)
    {
        $check_id = $request->check_id;
        $deli_date = $request->deli_date;

        $checkIDArr = explode(',',$check_id);

        $checks = WorkshopCheck::find($checkIDArr);

        $allData = array();
        //每頁格數
        $countPerPage = 9;

//        $shops = User::getKingBakeryShopsOrderBySort();
        $shops = $request->shops;
        $cartitemModel = new WorkshopCartItem();

        foreach ($checks as $check){

            //是否隱藏沒有數量的,1隱藏,0不隱藏
            $hideZero = $check->int_hide;

            $items = $check->item_list;

            $menuIdArr = explode(',',$items);

            $checkArr = array();
            foreach ($menuIdArr as $menu){
                $tempArr =  explode(':', $menu);
                $checkArr[] = $tempArr[1];
            }

            //計算下單數量總數
            $totals = $cartitemModel;
            $totals = $totals->select('users.id','users.report_name');

            $totals = $totals
                ->leftJoin('workshop_products', 'workshop_products.id', '=', 'workshop_cart_items.product_id')
                ->leftJoin('users', 'users.id', '=', 'workshop_cart_items.user_id')
                ->where('users.type', '=', 2)
                ->where('workshop_cart_items.status', '<>', 4)
                ->whereIn('workshop_cart_items.product_id', $checkArr)
                ->where('workshop_cart_items.deli_date', $deli_date)
                ->ofShop($shops)
                ->groupBy('users.id')
                //2020-12-28 根據車期排序
                ->orderBy('users.sort')
                ->havingRaw('SUM(IFNULL(workshop_cart_items.qty_received,
            workshop_cart_items.qty)) > 0')
                ->get();

//            //第二車
//            $secondShops = $cartitemModel
//                ->select('users.id','users.report_name')

//            dump($totals2nd->toArray());
//            dump($totals->toArray());
//            dump(count($totals));

            $ordershops = $totals->pluck('report_name','id');
//            dump($ordershops);

            //頁數
            $pageCount = (int)ceil(count($ordershops)/$countPerPage);
            //初始化頁數
            $page = 1;
//            dump($pageCount);

            //分頁顯示
            foreach ($ordershops->chunk($countPerPage) as $chunkshops){

                $datas = $cartitemModel
                    ->select('workshop_products.product_no as 編號' )
                    ->addSelect('workshop_products.product_name as 名稱')
                    ->addSelect(DB::raw("ROUND(sum(case when (workshop_cart_items.deli_date = '{$deli_date}') then ifnull(workshop_cart_items.qty_received,workshop_cart_items.qty) else 0 end),0) as Total"));

                foreach ($chunkshops->toArray() as $shopid => $shopname){

                    $sql = "ROUND(sum(case when (workshop_cart_items.user_id = '{$shopid}' and workshop_cart_items.dept != 'R2' and workshop_cart_items.deli_date = '{$deli_date}') then ifnull(workshop_cart_items.qty_received,workshop_cart_items.qty) else 0 end),0) as '{$shopname}'";
                    $datas = $datas
                        ->addSelect(DB::raw($sql));

                    //todo 2021-01-07 暫時寫死,只有油塘顯示二車
                    if($shopid == 33){
                        $sql = "ROUND(sum(case when (workshop_cart_items.user_id = '{$shopid}' and workshop_cart_items.dept = 'R2' and workshop_cart_items.deli_date = '{$deli_date}') then ifnull(workshop_cart_items.qty_received,workshop_cart_items.qty) else 0 end),0) as '{$shopname}2'";
                        $datas = $datas
                            ->addSelect(DB::raw($sql));
                    }


//            $sql = "ROUND(sum(case when (workshop_cart_items.user_id = '$shop->id' and workshop_cart_items.dept = 'B') then ifnull(workshop_cart_items.qty_received,workshop_cart_items.qty) else 0 end),0) as '$shop->report_name"."2'";
//            $datas = $datas
//                ->addSelect(DB::raw($sql));
//            $totals = $totals
//                ->addSelect(DB::raw($sql));
                }

                $datas = $datas
                    ->leftJoin('workshop_products', 'workshop_products.id', '=', 'workshop_cart_items.product_id')
                    ->leftJoin('workshop_groups', 'workshop_products.group_id', '=', 'workshop_groups.id')
                    ->leftJoin('workshop_cats', 'workshop_groups.cat_id', '=', 'workshop_cats.id')
                    ->leftJoin('users', 'users.id', '=', 'workshop_cart_items.user_id')
                    ->where('users.type', '=', 2)
                    ->where('workshop_cart_items.status', '<>', 4)
                    ->whereIn('workshop_cart_items.product_id', $checkArr);

                if($hideZero != 0){
                    $datas = $datas
                        ->where('workshop_cart_items.deli_date', $deli_date);
                }

                $datas = $datas
                    ->ofShop($shops)
                    ->groupBy('workshop_products.id')
                    ->orderBy('workshop_products.product_no')
                    ->orderBy('workshop_groups.id')
                    ->get();

//        dump($datas->toArray());

                $datas->title = $check->report_name;
                $datas->deli_date = $deli_date;
                //頁碼樣式 1/2
                $datas->page = $page.'/'.$pageCount;

                $page++;

                $allData[$check->id][] = $datas;

            }

        }

//        dump($allData);

        return view('admin.order_print.index',compact('allData'));
    }


}
