<?php

namespace App\Admin\Controllers\Export;

use App\Admin\Repositories\TblOrderZCat;
use App\Http\Controllers\Controller;
use App\Models\OrderZDept;
use App\Models\TblUser;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Grid;
use Illuminate\Support\Facades\DB;

//根據分店和貨品生成銷售報表報表
class SalesByShopAndMenuController extends AdminController
{
//    public function index()
//    {

//
//        return $orderzdept;
//    }

    protected function grid()
    {
        return Grid::make(new TblOrderZCat(), function (Grid $grid) {

//            $orderzdept = new OrderZDept;
//            $orderzdept = $orderzdept
//                ->select(DB::raw('tbl_order_z_menu.int_id , tbl_order_z_menu.chr_name, sum(tbl_order_z_dept.int_qty) as total_qty, tbl_user.chr_report_name,tbl_order_z_dept.int_user'))
//                ->leftJoin('tbl_order_z_menu', 'tbl_order_z_menu.int_id', '=', 'tbl_order_z_dept.int_product')
//                ->leftJoin('tbl_order_z_group', 'tbl_order_z_menu.int_group', '=', 'tbl_order_z_group.int_id')
//                ->leftJoin('tbl_user', 'tbl_user.int_id', '=', 'tbl_order_z_dept.int_user')
//                ->where('tbl_user.chr_type', '=', 2)
//                ->where('tbl_order_z_dept.status', '<>', 4)
//                ->whereRaw(DB::raw('DATE(DATE_ADD(tbl_order_z_dept.order_date, INTERVAL 1+tbl_order_z_dept.chr_phase DAY)) between "2020-06-01" and "2020-07-02"'))
//                ->groupBy('tbl_order_z_dept.int_user','tbl_order_z_menu.int_id')
//                ->orderBy('tbl_user.chr_report_name')
//                ->orderBy('tbl_order_z_menu.int_group')
//                ->get();

            $user = new TblUser();
            $shops = $user->where('chr_type', 2)->get(['int_id','chr_report_name']);

            $orderzdept = new OrderZDept;
            $orderzdept = $orderzdept
                ->select('tbl_order_z_menu.int_id' , 'tbl_order_z_menu.chr_name');


            foreach ($shops as $shop){
//                $sql = "sum(case when tbl_order_z_dept.int_user = '$shop->int_id' then tbl_order_z_dept.int_qty else 0 end) as '$shop->chr_report_name'";
//                dump($sql);
                $sql = "sum(case when tbl_order_z_dept.int_user = '$shop->int_id' then tbl_order_z_dept.int_qty else 0 end) as '$shop->chr_report_name'";
                $orderzdept = $orderzdept
                    ->addSelect(DB::raw($sql));
            }

            $orderzdept = $orderzdept
                ->leftJoin('tbl_order_z_menu', 'tbl_order_z_menu.int_id', '=', 'tbl_order_z_dept.int_product')
                ->leftJoin('tbl_order_z_group', 'tbl_order_z_menu.int_group', '=', 'tbl_order_z_group.int_id')
                ->leftJoin('tbl_user', 'tbl_user.int_id', '=', 'tbl_order_z_dept.int_user')
                ->where('tbl_user.chr_type', '=', 2)
                ->where('tbl_order_z_dept.status', '<>', 4)
                ->whereRaw(DB::raw('DATE(DATE_ADD(tbl_order_z_dept.order_date, INTERVAL 1+tbl_order_z_dept.chr_phase DAY)) between "2020-06-01" and "2020-06-01"'))
                ->groupBy('tbl_order_z_menu.int_id')
                ->get();

//            die();
//            dd($shop->toArray());



            dd($orderzdept->toArray());




        });
    }

}
