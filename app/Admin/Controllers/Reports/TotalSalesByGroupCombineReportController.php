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
use Illuminate\Support\Facades\DB;


//分店每月銷售總額報告(組合)
class TotalSalesByGroupCombineReportController extends AdminController
{
    public function index(Content $content)
    {
        return $content
            ->header('分店每月銷售總額報告(組合)')
            ->body($this->grid());
    }

    protected function grid()
    {
        return new Grid(null, function (Grid $grid) {

            $grid->header(function ($collection) {
                $start = $this->getStartTime();
                $end = $this->getEndTime();

                // 标题和内容
                $cardInfo = $start . " 至 " . $end;
                $card = Card::make('日期:', $cardInfo);

                return $card;
            });

            $start = $this->getStartTime();
            $end = $this->getEndTime();

            $data = $this->generate($start, $end);

            if (count($data) > 0) {
                $keys = $data->first()->toArray();
                foreach ($keys as $key => $values) {
//                    if($key == '大類'){
//                        $grid->column($key);
//                    }else{
//                        $grid->column($key);
//                    }

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

            $filename = '分店每月銷售總額報告(組合) ' . $start . '至' . $end;
            $grid->export()->xlsx()->filename($filename);


        });

    }

    /**
     * 生成数据
     *
     * @return array
     */
    public function generate($start, $end)
    {

        $cats = TblOrderZCat::getCatsExceptResale();
        $resales = TblOrderZGroup::getResaleGroups();
        $testids = TblUser::getTestUserIDs();

        $orderzdept = new OrderZDept;
        $orderzdept = $orderzdept
            ->select(DB::raw('tbl_user.int_id as "分店"'))
            ->addSelect(DB::raw('ROUND(sum(ifnull(tbl_order_z_dept.int_qty_received,tbl_order_z_dept.int_qty) * tbl_order_z_menu.int_default_price) , 2) as Total'));

        foreach ($cats as $cat) {
            $sql = "ROUND(sum(case when tbl_order_z_cat.int_id = '$cat->int_id' then (ifnull(tbl_order_z_dept.int_qty_received,tbl_order_z_dept.int_qty) * tbl_order_z_menu.int_default_price) else 0 end),2) as '$cat->chr_name'";
            $orderzdept = $orderzdept
                ->addSelect(DB::raw($sql));
        }

        foreach ($resales as $resale) {
            $sql = "ROUND(sum(case when tbl_order_z_menu.int_group = '$resale->int_id' then (ifnull(tbl_order_z_dept.int_qty_received,tbl_order_z_dept.int_qty) * tbl_order_z_menu.int_default_price) else 0 end),2) as '$resale->chr_name'";
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
            ->whereRaw(DB::raw("DATE(DATE_ADD(tbl_order_z_dept.order_date, INTERVAL 1+tbl_order_z_dept.chr_phase DAY)) between '$start' and '$end'"))
            ->groupBy('tbl_user.int_id')
            ->orderBy('tbl_user.txt_login')
//            ->orderBy('tbl_order_z_group.int_id')
            ->get();

//        dd($orderzdept->toArray());

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

    public function headings(): array
    {
        $shops = TblUser::getKingBakeryShops();

        $headings = ['編號', '名稱', 'Total'];
        foreach ($shops as $shop) {
            array_push($headings, $shop->chr_report_name);
        }

        return $headings;
    }
}
