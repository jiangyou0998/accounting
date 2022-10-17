<?php

namespace App\Admin\Controllers\Reports;


use App\Models\WarehouseProduct;
use App\Models\WarehouseProductPrice;
use Carbon\Carbon;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Widgets\Card;


//貨倉產品價格報告
class WarehouseProductPriceReportController extends AdminController
{
    public function index(Content $content)
    {
        return $content
            ->header('貨倉產品價格報告')
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

            $data = $this->generate($start, $end);

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
//                $filter->equal('group', '分組')->select(getReportShop());
            });

            $filename = '貨倉產品價格報告 ' . $start . '至' . $end;
            $grid->export()->csv()->filename($filename);

        });

    }

    /**
     * 生成数据
     *
     * @return array
     */
    public function generate($start_date, $end_date)
    {
        //todo 是否需要隱藏無價格產品
        $products = WarehouseProduct::query()
            ->whereHas('prices', function ($query) use($start_date, $end_date){
                $query->hasPrice($start_date, $end_date);
            })->get(['id', 'product_name']);

        $prices = WarehouseProductPrice::all();

        $start_date_carbon = Carbon::parse($start_date)->startOfMonth();
        $end_date_carbon = Carbon::parse($end_date)->startOfMonth();

        $monthArr = array();
        while ($start_date_carbon->lte($end_date_carbon)){
            $monthArr[] = $start_date_carbon->isoFormat('Y-MM');
            $start_date_carbon->addMonth();
        }

        //產品數組 $priceArr[產品ID][月份] = 產品價格
        //以每個月最後一日計算當月價格
        $priceArr = array();
        foreach ($prices as $price){
            foreach ($monthArr as $momth) {
                $end_date_of_month = Carbon::parse($momth)->endOfMonth()->toDateString();
                if($end_date_of_month >= $price->start_date
                && $end_date_of_month <= $price->end_date){
                    $priceArr[$price->product_id][$momth] = $price->price;
                }
            }
        }

        foreach ($products as $product){
            foreach ($monthArr as $momth){
                $product->{$momth} = $priceArr[$product->id][$momth] ?? '';
            }
        }

//        dump($monthArr);
//        dump($prices->toArray());
//        dump($priceArr);
//        dump($products->toArray());

        return $products;

    }

}
