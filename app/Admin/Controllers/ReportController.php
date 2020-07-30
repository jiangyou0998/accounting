<?php

namespace App\Admin\Controllers;

use App\Models\OrderZDept;
use App\Models\TblUser;
use Carbon\Carbon;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Grid;
use Illuminate\Support\Facades\DB;



class ReportController extends AdminController
{

    protected function grid()
    {
        return new Grid(null, function (Grid $grid) {

//            $grid->header(function ($collection) {
//                // 自定义组件
//                return new Card(new ExportReport());
//            });

//            $start = $_REQUEST['start'];
//            $end = $_REQUEST['end'];

            //上个月第一天
            if(isset($_REQUEST['between']['start'])){
                $start = $_REQUEST['between']['start'];
            }else{
                $start = Carbon::now()->subMonth()->firstOfMonth()->toDateString();
            }

            //上个月最后一天
            if(isset($_REQUEST['between']['end'])){
                $end = $_REQUEST['between']['end'];
            }else{
                $end = Carbon::now()->subMonth()->lastOfMonth()->toDateString();
            }

            $data = $this->generate($start,$end);

            if(count($data) > 0){
                $keys = $data->first()->toArray();
                foreach ($keys as $key => $values){
                    $grid->column($key);
                }
            }

            $grid->withBorder();

            //禁用 导出所有 选项
            $grid->export()->disableExportAll();
            //禁用 导出选中行 选项
            $grid->export()->disableExportSelectedRow();
            // 禁用行选择器
            $grid->disableRowSelector();
            $grid->disableCreateButton();
            $grid->disableActions();
            $grid->disableBatchDelete();
            $grid->disablePagination();

            // 设置表格数据
            $grid->model()->setData($data);

            $grid->filter(function (Grid\Filter $filter) {

                // 更改为 panel 布局
                $filter->panel();

                $filter->between('between', '報表日期')->date();


            });

            $filename = '分店每月銷售數量報告 '.$start.'至'.$end ;
            $grid->export()->xlsx()->filename($filename);


            });

    }

    /**
     * 生成数据
     *
     * @return array
     */
    public function generate($start,$end) {

        $shops = TblUser::getKingBakeryShops();

        $orderzdept = new OrderZDept;
        $orderzdept = $orderzdept
            ->select(DB::raw('tbl_order_z_menu.chr_no as "編號"' ))
            ->addSelect(DB::raw( 'tbl_order_z_menu.chr_name as "名稱"'))
            ->addSelect(DB::raw('sum(ifnull(tbl_order_z_dept.int_qty_received,tbl_order_z_dept.int_qty)) as Total'));


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
            ->whereRaw(DB::raw("DATE(DATE_ADD(tbl_order_z_dept.order_date, INTERVAL 1+tbl_order_z_dept.chr_phase DAY)) between '$start' and '$end'"))
            ->groupBy('tbl_order_z_menu.int_id')
            ->orderBy('tbl_order_z_menu.chr_no')
            ->get();

        return $orderzdept;

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
