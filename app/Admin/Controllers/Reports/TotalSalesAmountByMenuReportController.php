<?php

namespace App\Admin\Controllers\Reports;

use App\Models\WorkshopCartItem;
use App\User;
use Carbon\Carbon;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Widgets\Card;
use Illuminate\Support\Facades\DB;


//分店每月銷售數量報告
class TotalSalesAmountByMenuReportController extends AdminController
{
    public function index(Content $content)
    {
          return $content
            ->header('分店每月銷售數量報告')
            ->body($this->grid());
    }

    protected function grid()
    {
        return Grid::make(null, function (Grid $grid) {

            $grid->header(function ($collection) {
                $start = getStartTimeWithoutDefault();
                $end = getEndTimeWithoutDefault();

                // 标题和内容
                $cardInfo = $start." 至 ".$end ;
                $card = Card::make('日期:', $cardInfo);

                return $card;
            });

            $start = getStartTimeWithoutDefault();
            $end = getEndTimeWithoutDefault();

            $shop_group = request()->group ?? 0;
//            dump(request()->_selector['group']);

            $data = $this->generate($start, $end, $shop_group);

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
                $filter->equal('group', '分組')->select(getReportShop());
            });

            $filename = '分店每月銷售數量報告 '.$start.'至'.$end ;
            $grid->export()->csv()->filename($filename);


        });

    }

    /**
     * 生成数据
     *
     * @return array
     */
    public function generate($start, $end, $shop_group)
    {
        //上月開始,結束日期
        $last_month_start = (new Carbon($start))->subMonth()->firstOfMonth()->toDateString();
        $last_month_end = (new Carbon($start))->subMonth()->endOfMonth()->toDateString();

        if($shop_group === 0){
            $shops = User::getAllShopsAndCustomerShops();
        }else{
            $shops = User::getShopsByShopGroup($shop_group);
        }

        $shopids = $shops->pluck('id');

        $cartitem = new WorkshopCartItem();
        $cartitem = $cartitem
            ->select('workshop_products.product_no as 編號' )
            ->addSelect('workshop_products.product_name as 名稱');
//            ->addSelect(DB::raw('ROUND(sum(ifnull(workshop_cart_items.qty_received,workshop_cart_items.qty)),0) as Total'));
        //查詢上月
        $sql = "ROUND(sum(
            case when (workshop_cart_items.deli_date between '$last_month_start' and '$last_month_end')
            then ifnull(workshop_cart_items.qty_received,workshop_cart_items.qty) else 0 end),0)
            as 上月";
       $cartitem = $cartitem
            ->addSelect(DB::raw($sql));

        //查詢本月
        $sql = "ROUND(sum(
            case when (workshop_cart_items.deli_date between '$start' and '$end')
            then ifnull(workshop_cart_items.qty_received,workshop_cart_items.qty) else 0 end),0)
            as Total";
        $cartitem = $cartitem
            ->addSelect(DB::raw($sql));

        foreach ($shops as $shop){
//                $sql = "sum(case when workshop_cart_items.user_id = '$shop->id' then workshop_cart_items.qty else 0 end) as '$shop->chr_report_name'";
//                dump($sql);
            $sql = "ROUND(sum(case when (workshop_cart_items.user_id = '$shop->id' and
            workshop_cart_items.deli_date between '$start' and '$end')
             then ifnull(workshop_cart_items.qty_received,workshop_cart_items.qty) else 0 end),0) as '$shop->report_name'";
            $cartitem = $cartitem
                ->addSelect(DB::raw($sql));
        }

        $cartitem = $cartitem
            ->leftJoin('workshop_products', 'workshop_products.id', '=', 'workshop_cart_items.product_id')
            ->leftJoin('users', 'users.id', '=', 'workshop_cart_items.user_id')
            ->whereBetween('workshop_cart_items.deli_date', [$last_month_start, $end])
            ->where('workshop_cart_items.status', '<>', 4)
            ->whereIn('workshop_cart_items.user_id', $shopids)
//            ->whereRaw(DB::raw("workshop_cart_items.deli_date between '$start' and '$end'"))
            ->groupBy('workshop_products.id')
            ->orderBy('workshop_products.product_no')
            ->get();

        return $cartitem;

    }



}
