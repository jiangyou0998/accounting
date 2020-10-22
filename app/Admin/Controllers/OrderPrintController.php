<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\OrderZDept;
use App\Models\TblOrderCheck;
use App\Models\TblUser;
use App\Models\WorkshopCartItem;
use App\Models\WorkshopCat;
use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;


class OrderPrintController extends Controller
{

    public function print(Request $request)
    {
//        $checks = new TblOrderCheck();
//        $check = $checks::find(49);
//
//        $checkArr = array();
//
//        $menuIdArr = explode(',',$check->chr_item_list);
//        foreach ($menuIdArr as $menu){
//            $tempArr =  explode(':', $menu);
//            array_push($checkArr,$tempArr[1]);
//        }

//        $checkIds = implode($checkArr,',');

//        dd($checkArr);
//        dd($checkIds);

        $cat_id = $request->cat_id;
        $deli_date = $request->deli_date;

        $shops = User::getRyoyuBakeryShops();

        $cartitemModel = new WorkshopCartItem();
        $datas = $cartitemModel
            ->select('workshop_products.product_no as 編號' )
            ->addSelect('workshop_products.product_name as 名稱')
            ->addSelect(DB::raw('ROUND(SUM(ifnull(workshop_cart_items.qty_received,workshop_cart_items.qty)) , 0) as Total'));

        $totals = $cartitemModel;

        foreach ($shops as $shop){
//                $sql = "sum(case when workshop_cart_items.user_id = '$shop->id' then workshop_cart_items.qty else 0 end) as '$shop->chr_report_name'";
//                dump($sql);
            $sql = "ROUND(sum(case when (workshop_cart_items.user_id = '$shop->id' and workshop_cart_items.dept != 'B') then ifnull(workshop_cart_items.qty_received,workshop_cart_items.qty) else 0 end),0) as '$shop->report_name'";
            $datas = $datas
                ->addSelect(DB::raw($sql));
            $totals = $totals
                ->addSelect(DB::raw($sql));

            $sql = "ROUND(sum(case when (workshop_cart_items.user_id = '$shop->id' and workshop_cart_items.dept = 'B') then ifnull(workshop_cart_items.qty_received,workshop_cart_items.qty) else 0 end),0) as '$shop->report_name"."2'";
            $datas = $datas
                ->addSelect(DB::raw($sql));
            $totals = $totals
                ->addSelect(DB::raw($sql));
        }

        $datas = $datas
            ->leftJoin('workshop_products', 'workshop_products.id', '=', 'workshop_cart_items.product_id')
            ->leftJoin('workshop_groups', 'workshop_products.group_id', '=', 'workshop_groups.id')
            ->leftJoin('workshop_cats', 'workshop_groups.cat_id', '=', 'workshop_cats.id')
            ->leftJoin('users', 'users.id', '=', 'workshop_cart_items.user_id')
            ->where('users.type', '=', 2)
            ->where('workshop_cart_items.status', '<>', 4)
            ->where('workshop_cats.id',$cat_id)
            ->where('workshop_cart_items.deli_date', $deli_date)
            ->groupBy('workshop_products.id')
            ->orderBy('workshop_products.product_no')
            ->orderBy('workshop_groups.id')
            ->get();

//        dump($datas->toArray());
        $totals = $totals
            ->leftJoin('workshop_products', 'workshop_products.id', '=', 'workshop_cart_items.product_id')
            ->leftJoin('workshop_groups', 'workshop_products.group_id', '=', 'workshop_groups.id')
            ->leftJoin('workshop_cats', 'workshop_groups.cat_id', '=', 'workshop_cats.id')
            ->leftJoin('users', 'users.id', '=', 'workshop_cart_items.user_id')
            ->where('users.type', '=', 2)
            ->where('workshop_cart_items.status', '<>', 4)
            ->where('workshop_cats.id',$cat_id)
            ->where('workshop_cart_items.deli_date', $deli_date)
            ->first();

        $heading_shops = array();
//        dump($totals->toArray());
        foreach ($totals->toArray() as $key=>$total){
//            dump($total);
            if($total != '0'){
                $heading_shops[] = $key;
            }
        }
//        dump(in_array('奧海城2',$heading_shops));

        $headings = [];
        if($datas->first()){
            $headings = $datas->first()->toArray();
        }

//        dump($datas->toArray());
        $checkInfos = new Collection();
        $checkInfos->title = WorkshopCat::find($cat_id)->cat_name;
        $checkInfos->deli_date = $deli_date;

        return view('admin.order_print.index',compact('datas' ,'headings', 'heading_shops','checkInfos'));
    }


}
