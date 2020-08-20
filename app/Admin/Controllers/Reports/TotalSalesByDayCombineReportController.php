<?php

namespace App\Admin\Controllers\Reports;

use App\Models\OrderZDept;
use App\Models\TblOrderZCat;
use App\Models\TblOrderZGroup;
use App\Models\TblUser;
use Carbon\Carbon;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Widgets\Card;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;


//分店每月銷售總額報告(按日)
class TotalSalesByDayCombineReportController extends AdminController
{
    public function index(Content $content)
    {
        return $content
            ->header('分店每月銷售總額報告(按日)')
            ->body($this->grid());
    }

    protected function grid()
    {
        return new Grid(null, function (Grid $grid) {

            $grid->header(function ($collection) {

                $month = $this->getMonth();

                // 标题和内容
                $cardInfo = $month;
                $card = Card::make('日期:', $cardInfo);

                return $card;
            });

            $month = $this->getMonth();

            $data = $this->generate($month);

            if (count($data) > 0) {
                $keys = $data->first()->toArray();
                foreach ($keys as $key => $values) {

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

//                $filter->between('between', '報表日期')->date();
                $filter->month('month', '報表日期');


            });

            $filename = '分店每月銷售總額報告(按日) ' . $month ;
            $grid->export()->csv()->filename($filename);


        });

    }

    /**
     * 生成数据
     *
     * @return array
     */
    public function generate($month)
    {

        $cats = TblOrderZCat::getCats();
        $testids = TblUser::getTestUserIDs();

        $orderzdept = new OrderZDept;
        $orderzdept = $orderzdept
            ->select(DB::raw("DATE_format(DATE(DATE_ADD(tbl_order_z_dept.insert_date,
            INTERVAL 1 + tbl_order_z_dept.chr_phase DAY)),'%Y-%m-%d') as day"))
            ->addSelect(DB::raw("(DATE_FORMAT(DATE(DATE_ADD(tbl_order_z_dept.insert_date,
                    INTERVAL 1 + tbl_order_z_dept.chr_phase DAY)),
            '%e')-1) div 7 as week"))

            ->addSelect(DB::raw('ROUND(sum(ifnull(tbl_order_z_dept.int_qty_received,tbl_order_z_dept.int_qty) * tbl_order_z_menu.int_default_price) , 2) as Total'));

        foreach ($cats as $cat) {
            $sql = "ROUND(sum(case when tbl_order_z_cat.int_id = '$cat->int_id' then (ifnull(tbl_order_z_dept.int_qty_received,tbl_order_z_dept.int_qty) * tbl_order_z_menu.int_default_price) else 0 end),2) as '$cat->chr_name'";
            $orderzdept = $orderzdept
                ->addSelect(DB::raw($sql));
        }

        $orderzdept = $orderzdept
            ->leftJoin('tbl_order_z_menu', 'tbl_order_z_menu.int_id', '=', 'tbl_order_z_dept.int_product')
            ->leftJoin('tbl_order_z_group', 'tbl_order_z_menu.int_group', '=', 'tbl_order_z_group.int_id')
            ->leftJoin('tbl_order_z_cat', 'tbl_order_z_group.int_cat', '=', 'tbl_order_z_cat.int_id')
            ->leftJoin('tbl_user', 'tbl_user.int_id', '=', 'tbl_order_z_dept.int_user')
            ->where('tbl_user.chr_type', '=', 2)
            ->where('tbl_order_z_dept.status', '<>', 4)
            ->whereNotIn('tbl_user.int_id', $testids)
            ->whereRaw(DB::raw("DATE(DATE_ADD(tbl_order_z_dept.insert_date, INTERVAL 1+tbl_order_z_dept.chr_phase DAY)) like '%$month%' "))
            ->groupBy(DB::raw('week,day with rollup'))
            ->get();


        foreach ($orderzdept as $value){
            if($value->day){
                $value->week = (new Carbon($value->day))->isoFormat('dd');
            }else{
                $value->week = '';
            }

        }

        return $orderzdept;

    }

    public function getStartTime()
    {
        if (isset($_REQUEST['between']['start'])) {
            $start = $_REQUEST['between']['start'];
        } else {
            //上个月第一天
            $start = Carbon::now()->subMonth()->firstOfMonth()->toDateString();
        }
        return $start;
    }

    public function getEndTime()
    {
        if (isset($_REQUEST['between']['end'])) {
            $end = $_REQUEST['between']['end'];
        } else {
            //上个月最后一天
            $end = Carbon::now()->subMonth()->lastOfMonth()->toDateString();
        }
        return $end;
    }

    public function getMonth()
    {
        if (isset($_REQUEST['month'])) {
            $month = $_REQUEST['month'];
        } else {
            //上个月最后一天
            $month = Carbon::now()->subMonth()->isoFormat('Y-MM');
        }
        return $month;
    }

}
