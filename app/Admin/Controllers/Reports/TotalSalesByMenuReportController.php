<?php

namespace App\Admin\Controllers\Reports;

use App\Admin\Renderable\ProductTable;
use App\Models\WorkshopCartItem;
use App\Models\WorkshopProduct;
use App\User;
use Carbon\Carbon;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Widgets\Card;
use Illuminate\Support\Facades\DB;


//分店每月銷售總額報告
class TotalSalesByMenuReportController extends AdminController
{
    public function index(Content $content)
    {
          return $content
            ->header('分店每月銷售總額報告')
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

            //當前產品id
            $product_id = isset($_REQUEST['product_id']) ? $_REQUEST['product_id'] : "";

            $data = $this->generate($start, $end, $shop_group, $product_id);

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

                $filter->equal('product_id', '產品')
                    ->multipleSelectTable(ProductTable::make()) // 设置渲染类实例，并传递自定义参数
                    ->title('弹窗标题')
                    ->dialogWidth('50%') // 弹窗宽度，默认 800px
                    ->model(WorkshopProduct::class, 'id', 'product_name'); // 设置编辑数据显示

                $filter->equal('group', '分組')->select(getReportShop());
            });

            $filename = '分店每月銷售總額報告 '.$start.'至'.$end ;
            $grid->export()->csv()->filename($filename);


        });

    }

    /**
     * 生成数据
     *
     * @return array
     */
    public function generate($start, $end, $shop_group, $product_id = null)
    {
        //上月開始,結束日期
        $last_month_start = (new Carbon($start))->subMonth()->firstOfMonth()->toDateString();
        $last_month_end = (new Carbon($start))->subMonth()->endOfMonth()->toDateString();

        $product_ids = explode(',', $product_id);

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

        foreach ($shops as $shop){
//                $sql = "sum(case when workshop_cart_items.user_id = '$shop->id' then workshop_cart_items.qty else 0 end) as '$shop->chr_report_name'";
//                dump($sql);
            $sql = "ROUND(sum(case when (workshop_cart_items.user_id = '$shop->id' and
            workshop_cart_items.deli_date between '$start' and '$end')
             then (ifnull(workshop_cart_items.qty_received,workshop_cart_items.qty) * workshop_cart_items.order_price) else 0 end),2) as '$shop->report_name'";
            $cartitem = $cartitem
                ->addSelect(DB::raw($sql));
        }

        //查詢單位
        $cartitem = $cartitem
            ->addSelect('workshop_units.unit_name as 單位');

        $cartitem = $cartitem
            ->leftJoin('workshop_products', 'workshop_products.id', '=', 'workshop_cart_items.product_id')
//            ->leftJoin('users', 'users.id', '=', 'workshop_cart_items.user_id')
            ->leftJoin('workshop_units', 'workshop_units.id', '=', 'workshop_products.unit_id');

        if ($product_id) {
            $cartitem = $cartitem->whereIn('workshop_products.id', $product_ids);
        }

        $cartitem = $cartitem
            ->whereBetween('workshop_cart_items.deli_date', [$last_month_start, $end])
            ->where('workshop_cart_items.status', '<>', 4)
            ->whereIn('workshop_cart_items.user_id', $shopids)
//            ->whereRaw(DB::raw("workshop_cart_items.deli_date between '$start' and '$end'"))
            ->groupBy('workshop_products.id')
            ->orderBy('workshop_products.product_no')
            ->get();


//        if($shop_group !== 0){
//            $prices = WorkshopProduct::with('prices')->whereHas('prices', function (Builder $query) use($shop_group){
//                $query->where('shop_group_id', '=', $shop_group);
//            })->get()->mapWithKeys(function ($item) use($shop_group){
//                $price = $item['prices']->where('shop_group_id', $shop_group)->first()->price;
//                return [$item['product_no'] => $price ];
//            });
////            dump($prices);
//
//            foreach ($cartitem as $v){
////                dd($v);
//                $v->單價 = $prices[$v->編號] ?? '\\';
////                $v->splice(4, 0, ['單價'=> $prices[$v->編號]]);
//            }
//        }

        return $cartitem;

    }



}
