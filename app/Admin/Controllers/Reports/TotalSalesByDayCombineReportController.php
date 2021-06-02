<?php

namespace App\Admin\Controllers\Reports;

use App\Models\TblOrderZCat;
use App\Models\TblOrderZGroup;
use App\Models\WorkshopCartItem;
use App\Models\WorkshopCat;
use App\User;
use Carbon\Carbon;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Widgets\Card;
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
        return Grid::make(null, function (Grid $grid) {

            $grid->header(function ($collection) {
                $shop_group = request()->group ?? 'all';
                switch ($shop_group) {
                    case 'all':
                        $shop_group_name = '全部';
                        break;
                    case 'kb':
                        $shop_group_name = '蛋撻王';
                        break;
                    case 'rb':
                        $shop_group_name = '糧友';
                        break;
                    default:
                        $shop_group_name = '全部';
                }
                $month = $this->getMonth();

                // 标题和内容
                $cardInfo = <<<HTML
        <h1>月份:<span style="color: red">$month</span></h1>
        <h1>分組:<span style="color: red">$shop_group_name</span></h1>
HTML;
                $card = Card::make('', $cardInfo);
//                $card = Card::make('xxx:', $shop_group);


                return $card;
            });

            $month = $this->getMonth();
            $shop_group = request()->group ?? 0;

            $data = $this->generate($month, $shop_group);

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
                $filter->month('month', '報表日期');
                $filter->equal('group', '分組')->select(getReportShop());

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
    public function generate($month ,$shop_group)
    {
        if($shop_group === 0){
            $shops = User::getAllShopsAndCustomerShops();
        }else{
            $shops = User::getShopsByShopGroup($shop_group);
        }

        $shopids = $shops->pluck('id');

        $cats = WorkshopCat::getCats();
        $testids = User::getTestUserIDs();

        $cartitem = new WorkshopCartItem();
        $cartitem = $cartitem
            ->select(DB::raw("DATE_format(deli_date,'%Y-%m-%d') as day"))
            ->addSelect(DB::raw("(DATE_FORMAT(deli_date,'%e')-1) div 7 as week"))

            ->addSelect(DB::raw('ROUND(sum(ifnull(workshop_cart_items.qty_received,workshop_cart_items.qty) * workshop_cart_items.order_price) , 2) as Total'));

        foreach ($cats as $cat) {
            $sql = "ROUND(sum(case when workshop_cats.id = '$cat->id' then (ifnull(workshop_cart_items.qty_received,workshop_cart_items.qty) * workshop_cart_items.order_price) else 0 end),2) as '$cat->cat_name'";
            $cartitem = $cartitem
                ->addSelect(DB::raw($sql));
        }

        $cartitem = $cartitem
            ->leftJoin('workshop_products', 'workshop_products.id', '=', 'workshop_cart_items.product_id')
            ->leftJoin('workshop_groups', 'workshop_products.group_id', '=', 'workshop_groups.id')
            ->leftJoin('workshop_cats', 'workshop_groups.cat_id', '=', 'workshop_cats.id')
            ->leftJoin('users', 'users.id', '=', 'workshop_cart_items.user_id')
//            ->where('users.type', '=', 2)
            ->where('workshop_cart_items.status', '<>', 4)
            ->whereIn('workshop_cart_items.user_id', $shopids)
            ->whereNotIn('users.id', $testids)
            ->whereRaw(DB::raw("deli_date like '%$month%' "))
            ->groupBy(DB::raw('week,day with rollup'))
            ->get();


        foreach ($cartitem as $value){
            if($value->day){
                $value->week = (new Carbon($value->day))->isoFormat('dd');
            }else{
                $value->week = '';
            }

        }

        //新增小計字樣
        if($cartitem->count()){
            foreach ($cartitem as $key => &$value){
                if( ! $value->day) $value->day = '本週小計';
            }
            $cartitem->last()->day = '總計';
        }

        return $cartitem;

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
        if (isset($_REQUEST['month']) && $_REQUEST['month'] != '') {
            $month = $_REQUEST['month'];
        } else {
            //上个月最后一天
            $month = Carbon::now()->subMonth()->isoFormat('Y-MM');
        }
        return $month;
    }

}
