<?php

namespace App\Admin\Controllers\Reports;

use App\Models\StockItem;
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
class StockByMonthReportController extends AdminController
{
    public function index(Content $content)
    {
        return $content
            ->header('每月庫存報告')
            ->body($this->grid());
    }

    protected function grid()
    {
        return Grid::make(null, function (Grid $grid) {

            $grid->header(function ($collection) {

                $month = getMonth();

                // 标题和内容
                $cardInfo = <<<HTML
        <h1>月份:<span style="color: red">$month</span></h1>
HTML;
                $card = Card::make('', $cardInfo);

                return $card;
            });

            $month = getMonth();

            $shop_group = request()->group ?? 0;

            $data = $this->generate($month, $shop_group);

            if(count($data) > 0){
                $keys = array_keys($data[0]);
                foreach ($keys as $key => $values){

                    $grid->column($values);

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
//                $filter->equal('group', '分組')->select(getReportShop());
            });

            $filename = '每月庫存報告 '.$month ;
            $grid->export()->csv()->filename($filename);

            });

    }

    /**
     * 生成数据
     *
     * @return array
     */
    public function generate($month, $shop_group){

        $shop_group = 1;

        //月份格式202106
        $month = Carbon::parse($month)->isoFormat('YMM');

        $stockitems = StockItem::query()
            ->where('month', $month)
            ->get();

        //
        $stockitemsArr = [];
        foreach ($stockitems as $stockitem){
            $stockitemsArr[$stockitem->product_id][$stockitem->user_id] = $stockitem->toArray();
        }

//        dump($stockitemsArr);

        $productsArr = WorkshopProduct::select('id', 'product_name', 'product_no')
            ->ofShopGroup($shop_group)
            ->notDisabled()
            ->orderBy('product_no')
            ->get()
            ->toArray();

        $shopsArr = User::getShopsByShopGroup($shop_group)
            ->pluck('report_name', 'id')
            ->toArray();

        //將stockitems數據填入數組
        foreach ($productsArr as &$product){
            foreach ($shopsArr as $shop_id => $shop_name){
                $product[$shop_name] = $stockitemsArr[$product['id']][$shop_id]['qty'] ?? 0;
            }
        }
//        dd($productsArr);

        return $productsArr;
    }
}
