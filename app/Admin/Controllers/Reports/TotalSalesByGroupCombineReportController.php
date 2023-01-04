<?php

namespace App\Admin\Controllers\Reports;

use App\Models\WorkshopCartItem;
use App\Models\WorkshopCat;
use App\Models\WorkshopGroup;
use App\User;
use Carbon\Carbon;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Widgets\Card;
use Illuminate\Support\Facades\DB;


//分店銷售類別額報告(大類)
class TotalSalesByGroupCombineReportController extends AdminController
{
    const TITLE = '分店銷售類別額報告(大類)';

    public function index(Content $content)
    {
        return $content
            ->header(self::TITLE)
            ->body($this->grid());
    }

    protected function grid()
    {
        return Grid::make(null, function (Grid $grid) {

            $grid->header(function ($collection) {
                $start = getStartTime();
                $end = getEndTime();

                // 标题和内容
                $cardInfo = $start . " 至 " . $end;
                $card = Card::make('日期:', $cardInfo);

                return $card;
            });

            $start = getStartTime();
            $end = getEndTime();

            $shop_group = request()->group ?? 0;

            $data = $this->generate($start, $end, $shop_group);

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
                $filter->equal('group', '分組')->select(getReportShop());

            });

            $filename = self::TITLE . ' ' . $start . '至' . $end;
            $grid->export()->csv()->filename($filename);


        });

    }

    /**
     * 生成数据
     *
     * @return array
     */
    public function generate($start, $end, $shop_group){

        //上月開始,結束日期
        $last_month_start = (new Carbon($start))->subMonth()->firstOfMonth()->toDateString();
        $last_month_end = (new Carbon($start))->subMonth()->endOfMonth()->toDateString();

        if($shop_group === 0){
            $shops = User::getAllShopsAndCustomerShops();
        }else{
            $shops = User::getShopsByShopGroup($shop_group);
        }

        $shopids = $shops->pluck('id');

        $cats = WorkshopCat::getCatsExceptResale();
        $resales = WorkshopGroup::getResaleGroups();
        $testids = User::getTestUserIDs();

        $cartitem = new WorkshopCartItem();
        $cartitem = $cartitem
            ->select('users.report_name as 分店');
//            ->addSelect(DB::raw('ROUND(sum(ifnull(workshop_cart_items.qty_received,workshop_cart_items.qty) * workshop_cart_items.order_price) , 2) as Total'));

        //查詢上月
        $sql = "ROUND(sum(
            case when (workshop_cart_items.deli_date between '$last_month_start' and '$last_month_end')
            then (ifnull(workshop_cart_items.qty_received,workshop_cart_items.qty) * workshop_cart_items.order_price) else 0 end),2)
            as 上月";
        $cartitem = $cartitem
            ->addSelect(DB::raw($sql));

        //查詢本月
        $sql = "ROUND(sum(
            case when (workshop_cart_items.deli_date between '$start' and '$end')
            then (ifnull(workshop_cart_items.qty_received,workshop_cart_items.qty) * workshop_cart_items.order_price) else 0 end),2)
            as Total";
        $cartitem = $cartitem
            ->addSelect(DB::raw($sql));

        foreach ($cats as $cat) {
            $sql = "ROUND(sum(case when (workshop_cats.id = '$cat->id' and
            workshop_cart_items.deli_date between '$start' and '$end')
            then (ifnull(workshop_cart_items.qty_received,workshop_cart_items.qty) * workshop_cart_items.order_price) else 0 end),2) as '$cat->cat_name'";
            $cartitem = $cartitem
                ->addSelect(DB::raw($sql));
        }

        foreach ($resales as $resale) {
            $sql = "ROUND(sum(case when (workshop_products.group_id = '$resale->id' and
            workshop_cart_items.deli_date between '$start' and '$end')
            then (ifnull(workshop_cart_items.qty_received,workshop_cart_items.qty) * workshop_cart_items.order_price) else 0 end),2) as '$resale->group_name'";
            $cartitem = $cartitem
                ->addSelect(DB::raw($sql));
        }

        $cartitem = $cartitem
            ->leftJoin('workshop_products', 'workshop_products.id', '=', 'workshop_cart_items.product_id')
            ->leftJoin('workshop_groups', 'workshop_products.group_id', '=', 'workshop_groups.id')
            ->leftJoin('workshop_cats', 'workshop_groups.cat_id', '=', 'workshop_cats.id')
            ->leftJoin('users', 'users.id', '=', 'workshop_cart_items.user_id')
            ->whereBetween('workshop_cart_items.deli_date', [$last_month_start, $end])
            ->where('workshop_cart_items.status', '<>', 4)
            ->whereIn('workshop_cart_items.user_id', $shopids)
            ->whereNotIn('users.id', $testids)
//            ->whereRaw(DB::raw("deli_date between '$start' and '$end'"))
            ->groupBy('users.id')
            ->orderBy('users.name')
//            ->orderBy('workshop_groups.id')
            ->get();

//        dd($cartitem->toArray());

        return $cartitem;

    }

}
