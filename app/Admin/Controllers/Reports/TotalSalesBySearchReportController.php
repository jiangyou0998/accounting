<?php

namespace App\Admin\Controllers\Reports;

use App\Admin\Renderable\ShopTable;
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
        return Grid::make(null, function (Grid $grid) {

            $start = getStartTimeWithoutDefault();
            $end = getEndTimeWithoutDefault();

            $no_start = request()->start_no ?? "";

            $no_end = request()->end_no ?? $no_start;

            if($no_start > $no_end){
                $temp = $no_start;
                $no_start = $no_end;
                $no_end = $temp;
            }
//
//            $no_start = request()->no->start;
//            $no_end = request()->no->end;

            //當前產品id
            $product_id = isset($_REQUEST['product_id']) ? $_REQUEST['product_id'] : "";
            //選中的商店id
            $shop_id = isset($_REQUEST['shop_id']) ? $_REQUEST['shop_id'] : "";
            $shop = isset($_REQUEST['shop']) ? $_REQUEST['shop'] : "";

            $data = $this->generate($start, $end,$no_start,$no_end, $product_id, $shop_id);

            //2021-04-21 新增總價錢統計
            $total = 0;
            foreach ($data as $value){
                $total += $value['總價'];
            }

            $grid->header(function ($collection) use($total){

                $start = getStartTimeWithoutDefault();
                $end = getEndTimeWithoutDefault();

                // 标题和内容
                $cardInfo = <<<HTML
        <h1>日期:<span style="color: red">{$start} 至 {$end}</span></h1>
        <h1>總計:<span style="color: red">{$total}</span></h1>
HTML;
                $card = Card::make('', $cardInfo);

                return $card;
            });

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
                    ->model(WorkshopProduct::class, 'id', 'product_name'); // 设置编辑数据显示
//                $filter->equal('shop', '分店')->select('api/kbshop');

//                $filter->month('month', '報表日期');

                $filter->equal('shop_id', '分店')
                    ->multipleSelectTable(ShopTable::make()) // 设置渲染类实例，并传递自定义参数
                    ->title('弹窗标题')
                    ->dialogWidth('50%') // 弹窗宽度，默认 800px
                    ->model(User::class, 'id', 'txt_name'); // 设置编辑数据显示

                $filter->between('between', '報表日期')->date();

                $product_nos = WorkshopProduct::all()
                    ->where('status','!=' ,4)
                    ->sortBy('product_no')
                    ->pluck('product_name','product_no');


                $product_nos = $product_nos->map(function ($item, $key) {
                    return $key.'-'.$item;
                });

                $filter->equal('start_no', '開始編號')
                    ->select($product_nos);

                $filter->equal('end_no', '結束編號')
                    ->select($product_nos);

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
        $testids = User::getTestUserIDs();

        $cartitem = new WorkshopCartItem;
        $cartitem = $cartitem
            ->select(DB::raw("workshop_cart_items.deli_date as day"));

//        foreach ($cats as $cat) {
        //分店名
        $sql = "users.report_name as 分店";
        $cartitem = $cartitem->addSelect(DB::raw($sql));
        //產品編號
        $sql = "workshop_products.product_no as 產品編號";
        $cartitem = $cartitem->addSelect(DB::raw($sql));
        //產品名
        $sql = "workshop_products.product_name as 產品名";
        $cartitem = $cartitem->addSelect(DB::raw($sql));
        //數量
        $sql = "ROUND(sum(ifnull(workshop_cart_items.qty_received,workshop_cart_items.qty)),0) as '數量'";
        $cartitem = $cartitem->addSelect(DB::raw($sql));
        //單價
        $sql = "ROUND(MAX(workshop_cart_items.order_price),2) as '單價'";
        $cartitem = $cartitem->addSelect(DB::raw($sql));
        //總價
        $sql = "ROUND(sum((ifnull(workshop_cart_items.qty_received,workshop_cart_items.qty) * workshop_cart_items.order_price)),2) as '總價'";
        $cartitem = $cartitem->addSelect(DB::raw($sql));
//        }

        $cartitem = $cartitem
            ->leftJoin('workshop_products', 'workshop_products.id', '=', 'workshop_cart_items.product_id')
            ->leftJoin('users', 'users.id', '=', 'workshop_cart_items.user_id');

//        dump($product_ids);
        if ($product_id) {
            $cartitem = $cartitem->whereIn('workshop_products.id', $product_ids);
        }

//        dump($shop_ids);
        if ($shop_id) {
            $cartitem = $cartitem->whereIn('users.id', $shop_ids);
        }

        if($no_start && $no_end){
            $cartitem = $cartitem->whereBetween('workshop_products.product_no', [$no_start , $no_end]);
        }

        $cartitem = $cartitem
//            ->where('users.type', '=', 2)
            ->where('workshop_cart_items.status', '<>', 4)
            ->whereNotIn('users.id', $testids)
            ->whereRaw("workshop_cart_items.deli_date between '$start' and '$end'")
            ->groupBy(DB::raw('users.report_name ,workshop_products.product_no , workshop_products.product_name , day , users.name , workshop_products.product_no'))
            ->orderBy('users.name')
            ->orderBy('workshop_products.product_no')
            ->orderBy('day')
            ->having('數量', '!=', 0)
            ->get();

        return $cartitem;

    }

}
