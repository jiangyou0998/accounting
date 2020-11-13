<?php

namespace App\Admin\Controllers\Reports;

use App\Admin\Renderable\KBShopTable;
use App\Admin\Renderable\ProductTable;
use App\Models\OrderZDept;
use App\Models\TblOrderZMenu;
use App\Models\TblUser;
use Carbon\Carbon;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Widgets\Card;
use Illuminate\Support\Facades\DB;


//分店銷售查詢
class TotalSalesBySearchReportController extends AdminController
{
    public function index(Content $content)
    {
        return $content
            ->header('分店銷售查詢')
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

            if (isset($_REQUEST['chr_no']['start'])) {
                $no_start = $_REQUEST['chr_no']['start'];
            } else {
                //上个月第一天
                $no_start = "";
            }

            if (isset($_REQUEST['chr_no']['end'])) {
                $no_end = $_REQUEST['chr_no']['end'];
            } else {
                //上个月第一天
                $no_end = "";
            }
//
//            $no_start = request()->chr_no->start;
//            $no_end = request()->chr_no->end;

            //當前產品id
            $product_id = isset($_REQUEST['product_id']) ? $_REQUEST['product_id'] : "";
            //選中的商店id
            $shop_id = isset($_REQUEST['shop_id']) ? $_REQUEST['shop_id'] : "";
            $shop = isset($_REQUEST['shop']) ? $_REQUEST['shop'] : "";

            $data = $this->generate($start, $end,$no_start,$no_end, $product_id, $shop_id);

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

                $filter->equal('product_id', '產品')
                    ->multipleSelectTable(ProductTable::make()) // 设置渲染类实例，并传递自定义参数
                    ->title('弹窗标题')
                    ->dialogWidth('50%') // 弹窗宽度，默认 800px
                    ->model(TblOrderZMenu::class, 'int_id', 'chr_name'); // 设置编辑数据显示
//                $filter->equal('shop', '分店')->select('api/kbshop');

//                $filter->month('month', '報表日期');

                $filter->equal('shop_id', '分店')
                    ->multipleSelectTable(KBShopTable::make()) // 设置渲染类实例，并传递自定义参数
                    ->title('弹窗标题')
                    ->dialogWidth('50%') // 弹窗宽度，默认 800px
                    ->model(TblUser::class, 'int_id', 'txt_name'); // 设置编辑数据显示

                $filter->between('between', '報表日期')->date();
                $filter->between('chr_no', '編號範圍');

            });


            $filename = '分店銷售 ' . $start . '至' . $end;
            $grid->export()->csv()->filename($filename);


        });

    }

    /**
     * 生成数据
     *
     * @return array
     */
    public function generate($start, $end,$no_start,$no_end, $product_id, $shop_id)
    {
        $product_ids = explode(',', $product_id);
//        dump($product_ids);
        $shop_ids = explode(',', $shop_id);
//        $cats = TblOrderZCat::getCats();
        $testids = TblUser::getTestUserIDs();

        $orderzdept = new OrderZDept;
        $orderzdept = $orderzdept
            ->select(DB::raw("DATE_format(DATE(DATE_ADD(tbl_order_z_dept.insert_date,
            INTERVAL 1 + tbl_order_z_dept.chr_phase DAY)),'%Y-%m-%d') as day"));

//        foreach ($cats as $cat) {
        //分店名
        $sql = "tbl_user.chr_report_name as 分店";
        $orderzdept = $orderzdept->addSelect(DB::raw($sql));
        //產品編號
        $sql = "tbl_order_z_menu.chr_no as 產品編號";
        $orderzdept = $orderzdept->addSelect(DB::raw($sql));
        //產品名
        $sql = "tbl_order_z_menu.chr_name as 產品名";
        $orderzdept = $orderzdept->addSelect(DB::raw($sql));
        //數量
        $sql = "ROUND(sum(ifnull(tbl_order_z_dept.int_qty_received,tbl_order_z_dept.int_qty)),0) as '數量'";
        $orderzdept = $orderzdept->addSelect(DB::raw($sql));
        //單價
        $sql = "ROUND(MAX(tbl_order_z_menu.int_default_price),2) as '單價'";
        $orderzdept = $orderzdept->addSelect(DB::raw($sql));
        //總價
        $sql = "ROUND(sum((ifnull(tbl_order_z_dept.int_qty_received,tbl_order_z_dept.int_qty) * tbl_order_z_menu.int_default_price)),2) as '總價'";
        $orderzdept = $orderzdept->addSelect(DB::raw($sql));
//        }

        $orderzdept = $orderzdept
            ->leftJoin('tbl_order_z_menu', 'tbl_order_z_menu.int_id', '=', 'tbl_order_z_dept.int_product')
//            ->leftJoin('tbl_order_z_group', 'tbl_order_z_menu.int_group', '=', 'tbl_order_z_group.int_id')
//            ->leftJoin('tbl_order_z_cat', 'tbl_order_z_group.int_cat', '=', 'tbl_order_z_cat.int_id')
            ->leftJoin('tbl_user', 'tbl_user.int_id', '=', 'tbl_order_z_dept.int_user');

//        dump($product_ids);
        if ($product_id) {
            $orderzdept = $orderzdept->whereIn('tbl_order_z_menu.int_id', $product_ids);
        }

//        dump($shop_ids);
        if ($shop_id) {
            $orderzdept = $orderzdept->whereIn('tbl_user.int_id', $shop_ids);
        }

        if($no_start && $no_end){
            $orderzdept = $orderzdept->whereBetween('tbl_order_z_menu.chr_no', [$no_start , $no_end]);
        }

        $orderzdept = $orderzdept
            ->where('tbl_user.chr_type', '=', 2)
            ->where('tbl_order_z_dept.status', '<>', 4)
            ->whereNotIn('tbl_user.int_id', $testids)
            ->whereRaw("DATE(DATE_ADD(tbl_order_z_dept.insert_date, INTERVAL 1+tbl_order_z_dept.chr_phase DAY)) between '$start' and '$end'")
            ->groupBy(DB::raw('tbl_user.chr_report_name ,tbl_order_z_menu.chr_no , tbl_order_z_menu.chr_name , day , tbl_user.txt_login , tbl_order_z_menu.chr_no'))
            ->orderBy('tbl_user.txt_login')
            ->orderBy('tbl_order_z_menu.chr_no')
            ->orderBy('day')
            ->having('數量', '!=', 0)
            ->get();


        return $orderzdept;

    }

    public function getStartTime()
    {
        if (isset($_REQUEST['between']['start'])) {
            $start = $_REQUEST['between']['start'];
        } else {
            //上个月第一天
            $start = "";
        }
        return $start;
    }

    public function getEndTime()
    {
        if (isset($_REQUEST['between']['end'])) {
            $end = $_REQUEST['between']['end'];
        } else {
            //上个月最后一天
            $end = "";
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
