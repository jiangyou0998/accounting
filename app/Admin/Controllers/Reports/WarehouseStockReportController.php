<?php

namespace App\Admin\Controllers\Reports;


use App\Admin\Renderable\FrontUserTable;
use App\Models\WarehouseProductPrice;
use App\Models\WarehouseStockItem;
use App\Models\WorkshopUnit;
use App\User;
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

            $shop_ids = request()->shop_ids;

            $data = $this->generate($start, $end, $shop_ids);

            $titles = [
                'supplier_name' => '供應商',
                'product_no' => '編號',
                'product_name' => '名稱',
                'date' => '時間',
                //2022-06-21 新增invoice_no
                'invoice_no' => 'Invoice No',
                'group_name' => '分類',
                'unit_name' => '單位',
                'qty' => '數量',
                'unit_price' => '來貨價',
                'base_unit_name' => '重量單位',
                'base_qty' => '數量',
                'base_price' => '單價',
                'total_sum' => '總額',
                'shop_name' => '部門',
            ];

            foreach ($titles as $key => $value){
                $grid->column($key,$value);
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
                //2022-10-18 新增分店filter
                $filter->equal('shop_ids', '分店')
                    ->multipleSelectTable(FrontUserTable::make(['roles' => 'Ryoyu'])) // 设置渲染类实例，并传递自定义参数
                    ->title('弹窗标题')
                    ->dialogWidth('50%') // 弹窗宽度，默认 800px
                    ->model(User::class, 'id', 'txt_name'); // 设置编辑数据显示
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
    public function generate($start_date, $end_date, $shop_ids)
    {
        //月份格式202106
//        $month = Carbon::parse($month)->isoFormat('YMM');
        $start = Carbon::parse($start_date)->isoFormat('YMMDD');
        $end = Carbon::parse($end_date)->isoFormat('YMMDD');

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
//            DB::raw('warehouse_stock_items.unit_id as stock_unit_id'),
            DB::raw('warehouse_stock_items.qty as qty'),
            DB::raw('warehouse_stock_items.base_qty as base_qty'),
            DB::raw('users.txt_name as shop_name'),
        ])
            ->leftJoin('warehouse_products', 'warehouse_products.id', '=', 'warehouse_stock_items.product_id')
            ->leftJoin('users', 'users.id', '=', 'warehouse_stock_items.user_id')
            ->leftJoin('suppliers', 'suppliers.id', '=', 'warehouse_products.supplier_id')
            ->leftJoin('supplier_groups', 'supplier_groups.id', '=', 'warehouse_products.group_id')
            ->whereBetween('date', [$start, $end]);

        //2022-10-18 新增分店filter
        if($shop_ids){
            $supplier_items = $supplier_items->whereIn('users.id', explode(',', $shop_ids));
        }

        $items = $supplier_items
            ->orderBy('date')
            ->orderBy('shop_name')
            ->orderBy('type')
//            ->orderByRaw(DB::raw("FIND_IN_SET(supplier_name, '" . implode(',', $classId) . "'" . ')'))//按照指定顺序排序
            ->orderBy('group_name')
            ->orderBy('supplier_name')
            ->get();

        $units = WorkshopUnit::all()->pluck('unit_name', 'id')->toArray();

        $prices = WarehouseProductPrice::query()
            ->where('start_date', '<=', $start_date)
            ->orWhere('end_date', '>=', $end_date)
            ->get();

        //按「日期」和「產品id」分組的價錢數組
        $price_group_by_date_and_product_id = array();
        foreach ($prices as $price){
            $loop_start_date = Carbon::parse($start_date);
            $loop_end_date = Carbon::parse($end_date);

            //2022-10-14 修復無法獲取最後一日價格bug
            while ($loop_start_date <= $loop_end_date) {
                $price_group_by_date_and_product_id[$loop_start_date->isoFormat('YMMDD')][$price->product_id]['price'] = $price->price;
                $price_group_by_date_and_product_id[$loop_start_date->isoFormat('YMMDD')][$price->product_id]['base_price'] = $price->base_price;
                $loop_start_date->addDay();
            }
        }

        foreach ($items as &$item){

            //供應商貨品
            if( $item->type === 2 ){
                $item->unit_name = $units[$item->unit_id] ?? '';
                $item->unit_price = $price_group_by_date_and_product_id[$item->date][$item->product_id]['price'] ?? 0;

                $item->base_unit_name = $units[$item->base_unit_id] ?? '';
                $item->base_price = $price_group_by_date_and_product_id[$item->date][$item->product_id]['base_price'] ?? 0;

                $item->total_sum =
                    ($item->qty * $item->unit_price)
                    + ($item->base_qty * $item->base_price);

                //時間格式轉換
                $date = (string)$item->date;
                $item->date = Carbon::parse($date)->toDateString();
            }
        }

        return $items;

    }

}
