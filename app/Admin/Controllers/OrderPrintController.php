<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\OrderZDept;
use App\Models\TblOrderCheck;
use App\Models\TblUser;
use Illuminate\Support\Facades\DB;


class OrderPrintController extends Controller
{

    public function test()
    {
        $checks = new TblOrderCheck();
        $check = $checks::find(49);

        $checkArr = array();

        $menuIdArr = explode(',',$check->chr_item_list);
        foreach ($menuIdArr as $menu){
            $tempArr =  explode(':', $menu);
            array_push($checkArr,$tempArr[1]);
        }

//        $checkIds = implode($checkArr,',');

//        dd($checkArr);
//        dd($checkIds);

        $shops = TblUser::getKingBakeryShops();

        $datas = new OrderZDept;
        $datas = $datas
            ->select('tbl_order_z_menu.chr_no as 編號' )
            ->addSelect('tbl_order_z_menu.chr_name as 名稱')
            ->addSelect(DB::raw('ROUND(SUM(tbl_order_z_dept.int_qty) , 0) as Total'));

        foreach ($shops as $shop){
//                $sql = "sum(case when tbl_order_z_dept.int_user = '$shop->int_id' then tbl_order_z_dept.int_qty else 0 end) as '$shop->chr_report_name'";
//                dump($sql);
            $sql = "ROUND(sum(case when tbl_order_z_dept.int_user = '$shop->int_id' then tbl_order_z_dept.int_qty else 0 end),0) as '$shop->chr_report_name'";
            $datas = $datas
                ->addSelect(DB::raw($sql));
        }

        $datas = $datas
            ->leftJoin('tbl_order_z_menu', 'tbl_order_z_menu.int_id', '=', 'tbl_order_z_dept.int_product')
            ->leftJoin('tbl_order_z_group', 'tbl_order_z_menu.int_group', '=', 'tbl_order_z_group.int_id')
            ->leftJoin('tbl_order_z_cat', 'tbl_order_z_group.int_cat', '=', 'tbl_order_z_cat.int_id')
            ->leftJoin('tbl_user', 'tbl_user.int_id', '=', 'tbl_order_z_dept.int_user')
            ->where('tbl_user.chr_type', '=', 2)
            ->where('tbl_order_z_dept.status', '<>', 4)
            ->whereIn('tbl_order_z_menu.int_id',$checkArr)
            ->whereRaw("DATE(DATE_ADD(tbl_order_z_dept.insert_date, INTERVAL 1+tbl_order_z_dept.chr_phase DAY)) between '2020-07-11' and '2020-07-11'")
            ->groupBy('tbl_order_z_menu.int_id')
            ->orderBy('tbl_order_z_menu.chr_no')
            ->orderBy('tbl_order_z_group.int_id')
            ->get();

//        dump($datas->toArray());

        $headings = $datas->first()->toArray();
//        dump($datas->toArray());

        return view('admin.order_print.index',compact('datas' ,'headings'));
    }


}
