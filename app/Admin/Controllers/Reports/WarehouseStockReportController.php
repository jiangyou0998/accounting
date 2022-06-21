<?php

namespace App\Admin\Controllers\Reports;


use App\Models\Price;
use App\Models\StockItem;
use App\Models\Supplier\SupplierProduct;
use App\Models\SupplierStockItem;
use App\Models\WarehouseProduct;
use App\Models\WarehouseStockItem;
use App\Models\WorkshopUnit;
use Carbon\Carbon;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Widgets\Card;
use Illuminate\Support\Facades\DB;


//貨倉入貨報告
class WarehouseStockReportController extends AdminController
{
    public function index(Content $content)
    {
        return $content
            ->header('貨倉入貨報告')
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

            $titles = [
                'supplier_name' => '供應商',
                'product_no' => '編號',
                'product_name' => '名稱',
                'date' => '時間',
                //2022-06-21 新增invoice_no
                'invoice_no' => 'Invoice No',
                'group_name' => '分類',
                'unit_name' => '單位',
                'unit_qty' => '數量',
                'unit_price' => '來貨價',
                'base_unit_name' => '重量單位',
                'base_qty' => '數量',
                'base_price' => '單價',
                'shop_name' => '部門',
            ];

            foreach ($titles as $key => $value){
                if($key === 'date'){
                    $grid->column($key,$value)->display(function ($date){
                        $date = (string)$date;
                        return Carbon::parse($date)->toDateString();
                    });
                }else{
                    $grid->column($key,$value);
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

            $filename = '貨倉入貨報告 ' . $start . '至' . $end;
            $grid->export()->titles($titles)->csv()->filename($filename);

        });

    }

    /**
     * 生成数据
     *
     * @return array
     */
    public function generate($start, $end)
    {
        //月份格式202106
//        $month = Carbon::parse($month)->isoFormat('YMM');
        $start = Carbon::parse($start)->isoFormat('YMMDD');
        $end = Carbon::parse($end)->isoFormat('YMMDD');

        $supplier_items = WarehouseStockItem::query()->select([
            //供應商貨品type設定為2
            DB::raw('2 as type'),
            DB::raw('warehouse_stock_items.product_id as product_id'),
            DB::raw('warehouse_stock_items.date'),
            //2022-06-21 新增invoice_no
            DB::raw('warehouse_stock_items.invoice_no'),
            DB::raw('suppliers.name as supplier_name'),
            DB::raw('warehouse_products.product_no as product_no'),
            DB::raw('warehouse_products.product_name as product_name'),
            DB::raw('supplier_groups.name as group_name'),
            //單位ID(來貨單位)
            DB::raw('warehouse_products.unit_id as unit_id'),
            //包裝單位ID
            DB::raw('warehouse_products.base_unit_id as base_unit_id'),
            //收貨ID
            DB::raw('warehouse_stock_items.unit_id as stock_unit_id'),
            DB::raw('warehouse_stock_items.qty as qty'),
            DB::raw('users.txt_name as shop_name'),
        ])
            ->leftJoin('warehouse_products', 'warehouse_products.id', '=', 'warehouse_stock_items.product_id')
            ->leftJoin('users', 'users.id', '=', 'warehouse_stock_items.user_id')
            ->leftJoin('suppliers', 'suppliers.id', '=', 'warehouse_products.supplier_id')
            ->leftJoin('supplier_groups', 'supplier_groups.id', '=', 'warehouse_products.group_id')
            ->leftJoin('workshop_units', 'workshop_units.id', '=', 'warehouse_stock_items.unit_id')
            ->whereBetween('date', [$start, $end]);

//        dd($items->toArray());
//        $classId = ['蛋撻王工場'];
        $items = $supplier_items
            ->orderBy('date')
            ->orderBy('shop_name')
            ->orderBy('type')
//            ->orderByRaw(DB::raw("FIND_IN_SET(supplier_name, '" . implode(',', $classId) . "'" . ')'))//按照指定顺序排序
            ->orderBy('group_name')
            ->orderBy('supplier_name')
            ->get();

        $supplier_unit_prices = WarehouseProduct::all()->pluck('default_price', 'id')->toArray();
        $supplier_base_prices = WarehouseProduct::all()->pluck('base_price', 'id')->toArray();
        $units = WorkshopUnit::all()->pluck('unit_name', 'id')->toArray();

        foreach ($items as $value){

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
