<?php

namespace App\Http\Controllers;


use App\Models\Supplier\Supplier;
use App\Models\SupplierGroup;
use App\Models\WarehouseGroup;
use App\Models\WarehouseProduct;
use App\Models\WarehouseStockItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WarehouseStockController extends Controller
{
    //可以推遲幾天提交
    const DELAY_DAY = 0;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function select_day(){

        return view('warehouse_stock.select_day');
    }

    public function index(Request $request){

        $group = $request->group ?? '';
        $warehouse_group = $request->warehouse_group ?? '';
        $supplier = $request->supplier ?? '';
        $search = $request->search ?? '';
        $type = $request->type ?? '';
        $date = $request->date ?? '';
//        $times = $request->times ?? null;

        $product_ids = WarehouseProduct::where('status', 0)->get()->pluck('id');

        $products = WarehouseProduct::getProducts($product_ids, $warehouse_group, $supplier, $search, $type, $date);

        $groups = SupplierGroup::whereHas('warehouse_products', function ($query) use($product_ids){
            $query->whereIn('id', $product_ids);
        })->pluck('name', 'id')->toArray();

        $warehouse_groups = WarehouseGroup::whereHas('warehouse_products', function ($query) use($product_ids){
            $query->whereIn('id', $product_ids);
        })->pluck('name', 'id')->toArray();

        //供應商(按添加次數排序)
        $suppliers = Supplier::whereHas('warehouse_products', function ($query) use($product_ids){
            $query->whereIn('id', $product_ids);
        })->orderBy('warehouse_used_count', 'desc')->pluck('name', 'id')->toArray();

        //格式:20220429
        $currentdate = Carbon::now()->subDays(self::DELAY_DAY)->isoFormat('YMMDD');
        $date = Carbon::parse($request->input('date'))->isoFormat('YMMDD') ?? $currentdate;

        $warehouseStockItemModel = WarehouseStockItem::query()
            ->where('user_id', Auth::id())
            ->where('date', $date);

        $stockitems = (clone $warehouseStockItemModel)
            ->pluck('qty','product_id')
            ->toArray();

        $stockitem_units = (clone $warehouseStockItemModel)
            ->pluck('unit_id','product_id')
            ->toArray();

        //2022-06-08 已保存的product_id數組;
        $saved_product_ids = (clone $warehouseStockItemModel)
            ->pluck('product_id');

        //2022-06-08 已保存的supplier_id數組;
        $saved_supplier_ids = WarehouseProduct::query()
            ->whereIn('id', $saved_product_ids)
            ->distinct('supplier_id')
            ->pluck('supplier_id');

//        $times = (clone $warehouseStockItemModel)
//            ->distinct('times')
//            ->orderBy('times')
//            ->pluck('times');

        $warehouse_stock_items = WarehouseStockItem::query()
            ->with('product')
            ->whereBetween(DB::raw("date(`date`)"), [Carbon::now()->subDay(15), Carbon::now()])
            ->whereNotNull('times')
            ->orderBy('date')
            ->get()
            ;

        $tabs = array();
        foreach ($warehouse_stock_items as $item){
            $date_string = Carbon::parse((string)$item->date)->toDateString();
            $tabs[$item->product->supplier_id][$date_string] = $item->invoice_no;
        }

//        dump($tabs);

        return view('warehouse_stock.index', compact('products',
            'groups',
            'warehouse_groups',
            'suppliers',
            'tabs',
//            'times',
            'saved_supplier_ids',
            'stockitems',
            'stockitem_units'));
    }

    public function add(Request $request)
    {

        $user = $request->user();
        $product_id = $request->input('product_id');

        //格式:20220429
        $currentdate = Carbon::now()->subDays(self::DELAY_DAY)->isoFormat('YMMDD');
        $date = Carbon::parse($request->input('date'))->isoFormat('YMMDD') ?? $currentdate;

        $qty = $request->input('qty');
        $unit_id = $request->input('unit_id');

        // 从数据库中查询该商品是否已经在购物车中
        if ($stock = WarehouseStockItem::query()
            ->where('product_id', $product_id)
            ->where('user_id', $user->id)
            ->where('date', $date)
            ->first()) {

            // 如果存在则直接叠加商品数量
            $stock->update([
                'qty' => $qty,
                'unit_id' => $unit_id,
            ]);
        } else {

            // 否则创建一个新的购物车记录
            $stock = new WarehouseStockItem(['qty' => $qty, 'unit_id' => $unit_id]);
            $stock->product_id = $product_id;
            $stock->user_id = $user->id;
            $stock->date = $date;
            $stock->save();
        }

        return [];
    }

    public function delete(Request $request)
    {
        $user = $request->user();
        $product_id = $request->input('product_id');

        //格式:20220429
        $currentdate = Carbon::now()->subDays(self::DELAY_DAY)->isoFormat('YMMDD');
        $date = Carbon::parse($request->input('date'))->isoFormat('YMMDD') ?? $currentdate;

        // 刪除數據
        WarehouseStockItem::query()
            ->where('product_id', $product_id)
            ->where('user_id', $user->id)
            ->where('date', $date)
            ->delete();

        return [];
    }

    //保存批次
    public function saveInvoice(Request $request)
    {

        $shop_id = Auth::id();
        $date = $request->date ?? '';
        $invoice_no = $request->invoice_no ?? '';

        if ($date){
            //格式:20220429
            $date = Carbon::parse($request->input('date'))->isoFormat('YMMDD');
            $times = WarehouseStockItem::getMaxTimes($shop_id) + 1;

            DB::table('warehouse_stock_items')
                ->where('user_id', $shop_id)
//                ->where('date', $date)
                ->whereNull('invoice_no')
                ->update(
                    [
                        'invoice_no' => $invoice_no,
                        'times' => $times,
                        'date' => $date
                    ]
                );
        }

        return [];
    }
}
