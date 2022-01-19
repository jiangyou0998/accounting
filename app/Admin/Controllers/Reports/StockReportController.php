<?php

namespace App\Admin\Controllers\Reports;


use App\Models\Price;
use App\Models\StockItem;
use App\Models\Supplier\SupplierProduct;
use App\Models\SupplierStockItem;
use App\Models\WorkshopUnit;
use Carbon\Carbon;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Widgets\Card;
use Illuminate\Support\Facades\DB;


//分店銷售查詢
class StockReportController extends AdminController
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

            $data = $this->generate($month);

            $titles = [
                'supplier_name' => '供應商',
                'product_no' => '編號',
                'product_name' => '名稱',
                'group_name' => '分類',
                'unit_name' => '單位',
                'unit_qty' => '數量',
                'unit_price' => '來貨價',
                'base_unit_name' => '重量單位',
                'base_qty' => '數量',
                'base_price' => '單價',
                'shop_name' => '分店',
            ];

            foreach ($titles as $key => $value){
                $grid->column($key,$value);
            }

//            $grid->column('supplier_name','供應商');
//            $grid->column('product_no','編號');
//            $grid->column('product_name','名稱');
//            $grid->column('group_name','分類');
//            $grid->column('unit_name','單位');
//            $grid->column('unit_qty','數量');
//            $grid->column('unit_price','來貨價');
//            $grid->column('base_unit_name','重量單位');
//            $grid->column('base_qty','數量');
//            $grid->column('base_price','單價');
//            $grid->column('shop_name','分店');

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
            $grid->export()->titles($titles)->csv()->filename($filename);

        });

    }

    /**
     * 生成数据
     *
     * @return array
     */
    public function generate($month)
    {
        //月份格式202106
        $month = Carbon::parse($month)->isoFormat('YMM');

        //工場產品
        $factory_items = StockItem::query()->select([
            //自家貨品type設定為1
                DB::raw('1 as type'),
                DB::raw('stock_items.product_id as product_id'),
                DB::raw('"蛋撻王工場" as supplier_name'),
                DB::raw('workshop_products.product_no as product_no'),
                DB::raw('workshop_products.product_name as product_name'),
                DB::raw('workshop_groups.group_name as group_name'),
                //單位ID(來貨單位)
                DB::raw('workshop_products.unit_id as unit_id'),
                //包裝單位ID,工場產品暫時未有包裝單位
                DB::raw('workshop_products.unit_id as base_unit_id'),
                //收貨ID
                DB::raw('stock_items.unit_id as stock_unit_id'),
                DB::raw('stock_items.qty as qty'),
                DB::raw('users.txt_name as shop_name'),
            ])
            ->leftJoin('workshop_products', 'workshop_products.id', '=', 'stock_items.product_id')
            ->leftJoin('users', 'users.id', '=', 'stock_items.user_id')
            ->leftJoin('workshop_groups', 'workshop_groups.id', '=', 'workshop_products.group_id')
            ->leftJoin('workshop_units', 'workshop_units.id', '=', 'stock_items.unit_id')
            ->where('month', $month);

        $supplier_items = SupplierStockItem::query()->select([
            //供應商貨品type設定為2
            DB::raw('2 as type'),
            DB::raw('supplier_stock_items.product_id as product_id'),
            DB::raw('suppliers.name as supplier_name'),
            DB::raw('supplier_products.product_no as product_no'),
            DB::raw('supplier_products.product_name as product_name'),
            DB::raw('supplier_groups.name as group_name'),
            //單位ID(來貨單位)
            DB::raw('supplier_products.unit_id as unit_id'),
            //包裝單位ID
            DB::raw('supplier_products.base_unit_id as base_unit_id'),
            //收貨ID
            DB::raw('supplier_stock_items.unit_id as stock_unit_id'),
            DB::raw('supplier_stock_items.qty as qty'),
            DB::raw('users.txt_name as shop_name'),
        ])
            ->leftJoin('supplier_products', 'supplier_products.id', '=', 'supplier_stock_items.product_id')
            ->leftJoin('users', 'users.id', '=', 'supplier_stock_items.user_id')
            ->leftJoin('suppliers', 'suppliers.id', '=', 'supplier_products.supplier_id')
            ->leftJoin('supplier_groups', 'supplier_groups.id', '=', 'supplier_products.group_id')
            ->leftJoin('workshop_units', 'workshop_units.id', '=', 'supplier_stock_items.unit_id')
            ->where('month', $month);

//        dd($items->toArray());
//        $classId = ['蛋撻王工場'];
        $items = $factory_items->union($supplier_items)
            ->orderBy('shop_name')
            ->orderBy('type')
//            ->orderByRaw(DB::raw("FIND_IN_SET(supplier_name, '" . implode(',', $classId) . "'" . ')'))//按照指定顺序排序
            ->orderBy('group_name')
            ->orderBy('supplier_name')
            ->get();

        $factory_prices = Price::getProductPriceByShopGroup(1);
        $supplier_unit_prices = SupplierProduct::all()->pluck('default_price', 'id')->toArray();
        $supplier_base_prices = SupplierProduct::all()->pluck('base_price', 'id')->toArray();
        $units = WorkshopUnit::all()->pluck('unit_name', 'id')->toArray();

        foreach ($items as $value){
            //自家貨品
            if( $value->type === 1 ){
                $value->unit_name = $units[$value->stock_unit_id] ?? '';
                $value->unit_qty = '';
                $value->unit_price = $factory_prices[$value->product_id] ?? 0;

                $value->base_unit_name = '';
                $value->base_qty = '';
                $value->base_price = '';

                if( $value->stock_unit_id === $value->unit_id ){
                    $value->unit_qty = $value->qty;
                }
            }

            //供應商貨品
            if( $value->type === 2 ){
                $value->unit_name = $units[$value->unit_id] ?? '';
                $value->unit_qty = '';
                $value->unit_price = $supplier_unit_prices[$value->product_id] ?? 0;

                $value->base_unit_name = $units[$value->base_unit_id] ?? '';
                $value->base_qty = '';
                $value->base_price = $supplier_base_prices[$value->product_id] ?? 0;

                if( $value->stock_unit_id === $value->unit_id ){
                    $value->unit_qty = $value->qty;
                }elseif( $value->stock_unit_id === $value->base_unit_id){
                    $value->base_qty = $value->qty;
                }
            }
        }

//        dd($items);

        return $items;

    }

}
