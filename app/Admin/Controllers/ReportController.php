<?php

namespace App\Admin\Controllers;



use App\Admin\Forms\ExportReport;
use App\Models\OrderZDept;
use App\Models\TblUser;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Widgets\Alert;
use Dcat\Admin\Widgets\Card;
use Dcat\Admin\Widgets\Form;

use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\Input;


class ReportController extends AdminController
{

//    public function index(Content $content)
//    {
////        return $content
////            ->body($this->form())
////            ->header('Create Report')
////            ->description('生成報表');
//
//        return $content
//            ->title('网站设置')
//            ->body(new Card(new ExportReport()));
//    }

    protected function grid()
    {
        return new Grid(null, function (Grid $grid) {

            $grid->header(function ($collection) {
                // 自定义组件
                return new Card(new ExportReport());
            });

            $start = $_REQUEST['start'];
            $end = $_REQUEST['end'];
//            dd($this->headings());
            $data = $this->generate($start,$end);

            if(count($data) > 0){
                $keys = $data->first()->toArray();
                foreach ($keys as $key => $values){
                    $grid->column($key);
                }
            }

//


            $grid->withBorder();

            //禁用 导出所有 选项
            $grid->export()->disableExportAll();

            //禁用 导出选中行 选项
            $grid->export()->disableExportSelectedRow();




            $grid->disableCreateButton();
            $grid->disableActions();
            $grid->disableBatchDelete();
            $grid->disablePagination();

            // 设置表格数据
            $grid->model()->setData($data);

            $filename = 'Report '.$start.'至'.$end ;
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
            ->select('tbl_order_z_menu.chr_no' , 'tbl_order_z_menu.chr_name')
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

//        return $data;
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
