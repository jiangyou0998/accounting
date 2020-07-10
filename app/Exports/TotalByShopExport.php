<?php

namespace App\Exports;

use App\Models\OrderZDept;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TotalByShopExport implements FromCollection, WithHeadings, WithMapping
{
//    protected $data;
//
    //构造函数传值
//    public function __construct($data)
//    {
//        $this->data = $data;
//    }
    //数组转集合
    public function collection()
    {
        $orderzdept = new OrderZDept;
        $orderzdept = $orderzdept
            ->select(DB::raw('tbl_order_z_group.chr_name, sum(tbl_order_z_dept.int_qty * tbl_order_z_menu.int_default_price) as total_price, tbl_order_z_menu.int_group ,tbl_user.chr_report_name,tbl_order_z_dept.int_user'))
            ->leftJoin('tbl_order_z_menu', 'tbl_order_z_menu.int_id', '=', 'tbl_order_z_dept.int_product')
            ->leftJoin('tbl_order_z_group', 'tbl_order_z_menu.int_group', '=', 'tbl_order_z_group.int_id')
            ->leftJoin('tbl_user', 'tbl_user.int_id', '=', 'tbl_order_z_dept.int_user')
            ->where('tbl_user.chr_type', '=', 2)
            ->whereRaw(DB::raw('DATE(DATE_ADD(tbl_order_z_dept.order_date, INTERVAL 1+tbl_order_z_dept.chr_phase DAY)) between "2020-06-01" and "2020-07-02"'))
            ->groupBy('tbl_order_z_menu.int_group','tbl_user.int_id')
            ->orderBy('tbl_user.chr_report_name')
            ->orderBy('tbl_order_z_menu.int_group')
            ->get();

//        dd($orderzdept->toArray());

        return $orderzdept;
    }
    //业务代码
    public function createData()
    {
        //todo 业务
        return [
            ['编号', '姓名', '年龄'],
            [1, '小明', '18岁'],
            [4, '小红', '17岁']
       ];
    }

//    public function collection()
//    {
//        $orderzdept = new OrderZDept;
//
//        $orderzdept = $orderzdept
//            ->select(DB::raw('tbl_order_z_group.chr_name, sum(tbl_order_z_dept.int_qty * tbl_order_z_menu.int_default_price) as total_price, tbl_order_z_menu.int_group ,tbl_user.chr_report_name,tbl_order_z_dept.int_user'))
//            ->leftJoin('tbl_order_z_menu', 'tbl_order_z_menu.int_id', '=', 'tbl_order_z_dept.int_product')
//            ->leftJoin('tbl_order_z_group', 'tbl_order_z_menu.int_group', '=', 'tbl_order_z_group.int_id')
//            ->leftJoin('tbl_user', 'tbl_user.int_id', '=', 'tbl_order_z_dept.int_user')
//            ->where('tbl_user.chr_type', '=', 2)
//            ->whereRaw(DB::raw('DATE(DATE_ADD(tbl_order_z_dept.order_date, INTERVAL 1+tbl_order_z_dept.chr_phase DAY)) between "2020-06-01" and "2020-06-30"'))
//            ->groupBy('tbl_order_z_menu.int_group','tbl_user.int_id')
//            ->orderBy('tbl_user.chr_report_name')
//            ->orderBy('tbl_order_z_menu.int_group')
//            ->get();
//
//
//        $chr_report_name = $orderzdept->unique('chr_report_name')->pluck('chr_report_name','int_user');
//        $chr_name = $orderzdept->sortBy('int_group')->unique('chr_name')->pluck('chr_name','int_group');
//        dump($chr_name);
//        dump($chr_report_name->toArray());
//        $orders = array();
//        foreach ($orderzdept as $key => $value) {
//            if($value->chr_report_name !== ""){
//                $orders[$value->chr_report_name][$value->chr_name] = $value->total_price ;
//            }
//        }
//
//        $chr_name = $orderzdept->sortBy('int_group')->unique('chr_name')->pluck('chr_name');
//        $zipped = $orderzdept->zip($chr_name);
//        $excelArr[0] = [1,2,3];
//        array_push($excelArr,[4,5,6]);
////            dd($zipped->toArray());
//        return [1,2,3];
//    }

    public function headings(): array
    {
        return [
            'chr_name',
            'total_price',
            'chr_report_name',
        ];
    }

    /**
     * @var OrderZDept $orderzdept
     */

    public function map($orderzdept): array
    {
        // TODO: Implement map() method.
        return [
            [
                $orderzdept->chr_name,
                $orderzdept->total_price,
                $orderzdept->chr_report_name
            ]
        ];
    }
}
