<?php

namespace App\Exports;

use App\Models\OrderZDept;
use App\Models\TblUser;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class SalesByShopAndMenuExport implements FromCollection, WithHeadings
{

//    构造函数传值
//    public function __construct($data)
//    {
//        $this->data = $data;
//    }
    //数组转集合
    public function collection()
    {
//        $user = new TblUser();
//        $shops = $user->where('chr_type', 2)
//            ->where('txt_login','like','kb%')
//            ->orWhere('txt_login','like','ces%')
//            ->orWhere('txt_login','like','b&b%')
//            ->get(['int_id','chr_report_name']);

        $shops = TblUser::getKingBakeryShops();

        $orderzdept = new OrderZDept;
        $orderzdept = $orderzdept
            ->select('tbl_order_z_menu.chr_no' , 'tbl_order_z_menu.chr_name')
            ->addSelect(DB::raw('sum(ifnull(tbl_order_z_dept.int_qty_received,tbl_order_z_dept.int_qty)) as total'));


        foreach ($shops as $shop){
//                $sql = "sum(case when tbl_order_z_dept.int_user = '$shop->int_id' then tbl_order_z_dept.int_qty else 0 end) as '$shop->chr_report_name'";
//                dump($sql);
            $sql = "sum(case when tbl_order_z_dept.int_user = '$shop->int_id' then ifnull(tbl_order_z_dept.int_qty_received,tbl_order_z_dept.int_qty) else 0 end) as '$shop->chr_report_name'";
            $orderzdept = $orderzdept
                ->addSelect(DB::raw($sql));
        }

        $orderzdept = $orderzdept
            ->leftJoin('tbl_order_z_menu', 'tbl_order_z_menu.int_id', '=', 'tbl_order_z_dept.int_product')
            ->leftJoin('tbl_order_z_group', 'tbl_order_z_menu.int_group', '=', 'tbl_order_z_group.int_id')
            ->leftJoin('tbl_user', 'tbl_user.int_id', '=', 'tbl_order_z_dept.int_user')
            ->where('tbl_user.chr_type', '=', 2)
            ->where('tbl_order_z_dept.status', '<>', 4)
            ->whereRaw(DB::raw('DATE(DATE_ADD(tbl_order_z_dept.order_date, INTERVAL 1+tbl_order_z_dept.chr_phase DAY)) between "2020-07-01" and "2020-07-02"'))
            ->groupBy('tbl_order_z_menu.int_id')
            ->orderBy('tbl_order_z_menu.chr_no')
            ->get();

        return $orderzdept;

//        $tbluser = new TblUser();
//        return $tbluser::all();
    }

    public function headings(): array
    {
        $shops = TblUser::getKingBakeryShops();

        $headings = ['編號','名稱','Total'];
        foreach ($shops as $shop){
            array_push($headings,$shop->chr_report_name);
        }

        return $headings;
    }







}
