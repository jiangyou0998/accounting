<?php

namespace App\Http\Controllers;


use App\Http\Requests\WaraHouseInvoiceRequest;
use App\Models\Supplier\Supplier;
use App\Models\SupplierGroup;
use App\Models\WarehouseGroup;
use App\Models\WarehouseProduct;
use App\Models\WarehouseProductPrice;
use App\Models\WarehouseStockItem;
use App\Models\WarehouseStockItemForbidden;
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
//        $date = $request->date ?? '';
//        $times = $request->times ?? null;

        $product_ids = WarehouseProduct::where('status', 0)->get()->pluck('id');

        $products = WarehouseProduct::getProducts($product_ids, $warehouse_group, $supplier, $search, $type, null);

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
//        $currentdate = Carbon::now()->subDays(self::DELAY_DAY)->isoFormat('YMMDD');
//        $date = Carbon::parse($request->input('date'))->isoFormat('YMMDD') ?? $currentdate;

        $warehouseStockItemModel = WarehouseStockItem::query()
            ->where('user_id', Auth::id())
            ->whereNull('date')
            ->whereNull('invoice_no')
//            ->where('date', $date)
        ;

        $allstockitems = (clone $warehouseStockItemModel)->get();
        $stockitems = array();
        foreach ($allstockitems as $v){
            $stockitems[$v->product_id]['qty'] = $v->qty;
            $stockitems[$v->product_id]['base_qty'] = $v->base_qty;
        }

        //2022-06-08 已保存的product_id數組;
//        $saved_product_ids = (clone $warehouseStockItemModel)
//            ->pluck('product_id');
//
//        //2022-06-08 已保存的supplier_id數組;
//        $saved_supplier_ids = WarehouseProduct::query()
//            ->whereIn('id', $saved_product_ids)
//            ->distinct('supplier_id')
//            ->pluck('supplier_id');

        //已填寫項目數量
        $filled_count = (clone $warehouseStockItemModel)
            ->count();

//        dump($filled_count);

//        $times = (clone $warehouseStockItemModel)
//            ->distinct('times')
//            ->orderBy('times')
//            ->pluck('times');

        $tabs = WarehouseStockItem::getInvoiceTab();

        $forbidden = 0;
//        dump($stockitems);

        return view('warehouse_stock.index', compact('products',
            'groups',
            'warehouse_groups',
            'suppliers',
            'tabs',
//            'times',
            'filled_count',
//            'saved_supplier_ids',
            'stockitems',
            'forbidden'));
    }

    public function edit(Request $request){

        $warehouse_group = null;
        $supplier = $request->supplier ?? '';
        $search = null;
        $type = null;
//        $date = $request->date ?? '';
        $times = $request->times ?? null;

        $product_ids = WarehouseProduct::where('status', 0)->get()->pluck('id');

        $products = WarehouseProduct::getProducts($product_ids, $warehouse_group, $supplier, $search, $type, $times);
//        dump($products->toArray());

        $warehouse_groups = WarehouseGroup::whereHas('warehouse_products', function ($query) use($product_ids){
            $query->whereIn('id', $product_ids);
        })->pluck('name', 'id')->toArray();

        //供應商(按添加次數排序)
        $suppliers = Supplier::whereHas('warehouse_products', function ($query) use($product_ids){
            $query->whereIn('id', $product_ids);
        })->orderBy('warehouse_used_count', 'desc')->pluck('name', 'id')->toArray();

        //格式:20220429
//        $currentdate = Carbon::now()->subDays(self::DELAY_DAY)->isoFormat('YMMDD');
//        $date = Carbon::parse($request->input('date'))->isoFormat('YMMDD') ?? $currentdate;

        $warehouseStockItemModel = WarehouseStockItem::query()
            ->where('user_id', Auth::id())
            ->where('times', $times)
//            ->where('date', $date)
        ;

//        $stockitems = (clone $warehouseStockItemModel)
////            ->pluck('qty','product_id')
//                ->get()
//            ->mapToGroups(function ($item, $key) {
//                return [$item['product_id'] => $item['unit_id']];
//            })
//            ->toArray();
//
//        dump($stockitems);

        $allstockitems = (clone $warehouseStockItemModel)->get();
        $stockitems = array();
        foreach ($allstockitems as $v){
            $stockitems[$v->product_id]['qty'] = $v->qty;
            $stockitems[$v->product_id]['base_qty'] = $v->base_qty;
        }
//        dump($stockitems);


        //2022-06-08 已保存的product_id數組;
//        $saved_product_ids = (clone $warehouseStockItemModel)
//            ->pluck('product_id');
//
//        //2022-06-08 已保存的supplier_id數組;
//        $saved_supplier_ids = WarehouseProduct::query()
//            ->whereIn('id', $saved_product_ids)
//            ->distinct('supplier_id')
//            ->pluck('supplier_id');

        //已填寫項目數量
        $filled_count = (clone $warehouseStockItemModel)
            ->count();

//        dump($filled_count);

//        $times = (clone $warehouseStockItemModel)
//            ->distinct('times')
//            ->orderBy('times')
//            ->pluck('times');

        $tabs = WarehouseStockItem::getInvoiceTab();

        $invoice = WarehouseStockItem::query()
            ->where('times', $times)
            ->first();

        $forbidden = WarehouseStockItemForbidden::checkModifyPermission($invoice->date);

        //其中一個product_id, 用於查找當前supplier_id
        $one_of_the_product_id = (clone $warehouseStockItemModel)->first()->product_id ?? '';
        $one_of_the_product = WarehouseProduct::find($one_of_the_product_id);

        $invoice_info = array();
        $invoice_info['date'] = isset($invoice->date) ? Carbon::parse((string)$invoice->date)->toDateString() : '';
        $invoice_info['invoice_no'] = $invoice->invoice_no ?? '';
        $invoice_info['supplier_id'] = $one_of_the_product->supplier_id ?? '';

//        dump($invoice_info);

        return view('warehouse_stock.edit', compact('products',
            'warehouse_groups',
            'suppliers',
            'tabs',
//            'times',
            'invoice_info',
            'filled_count',
//            'saved_supplier_ids',
            'stockitems',
            'forbidden'));
    }

    public function add(Request $request)
    {
        $user = $request->user();
        $product_id = $request->input('product_id');
        $times = $request->input('times');

        $filled_count = WarehouseStockItem::query()
            ->where('user_id', Auth::id())
            ->where('times', $times)
            ->count();

        $qty = $request->input('qty');
        $base_qty = $request->input('base_qty');

        // 从数据库中查询该商品是否已经在购物车中
        if ($stock = WarehouseStockItem::query()
            ->where('product_id', $product_id)
            ->where('user_id', $user->id)
            ->ofTimes($times)
//            ->where('date', $date)
            ->first()) {

            $date = $stock->date;
            $forbidden = WarehouseStockItemForbidden::checkModifyPermission($date);

            if($forbidden > 0){
                return response()->json(array(
                    'code' => 403,
                    'error' => '該日期已禁止修改!',
                ));
            }

            // 如果存在则直接叠加商品数量
            $stock->update([
                'qty' => $qty,
                'base_qty' => $base_qty,
            ]);
        } else {

            // 否则创建一个新的购物车记录
            $stock = new WarehouseStockItem(['qty' => $qty, 'base_qty' => $base_qty]);
            $stock->product_id = $product_id;
            $stock->user_id = $user->id;

            if($times){
                $item = WarehouseStockItem::query()
                    ->where('user_id', $user->id)
                    ->where('times', $times)
                    ->first();

                $date = $item->date;
                $forbidden = WarehouseStockItemForbidden::checkModifyPermission($date);

                if($forbidden > 0){
                    return response()->json(array(
                        'code' => 403,
                        'error' => '該日期已禁止修改!',
                    ));
                }

                $stock->date = $item->date;
                $stock->times = $times;
                $stock->invoice_no = $item->invoice_no;

            }

            $stock->save();
        }

        if ($filled_count === 0){
            return response()->json(array(
                'code' => 200,
                'msg' => 'new',
            ));
        }

        return [];
    }

    public function delete(Request $request)
    {
        $user = $request->user();
        $product_id = $request->input('product_id');

        //格式:20220429
//        $currentdate = Carbon::now()->subDays(self::DELAY_DAY)->isoFormat('YMMDD');
//        $date = Carbon::parse($request->input('date'))->isoFormat('YMMDD') ?? $currentdate;

        // 刪除數據
        WarehouseStockItem::query()
            ->where('product_id', $product_id)
            ->where('user_id', $user->id)
//            ->where('date', $date)
            ->delete();

        return [];
    }

    //保存批次
    public function saveInvoice(WaraHouseInvoiceRequest $request)
    {
        $shop_id = Auth::id();
        $date = $request->date ?? '';
        $invoice_no = $request->invoice_no ?? '';

        $forbidden = WarehouseStockItemForbidden::checkModifyPermission($date);

        if($forbidden > 0){
            return response()->json(array(
                'code' => 403,
                'error' => '該日期已禁止修改!',
            ));
        }

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

    //編輯Invoice
    public function editInvoice(WaraHouseInvoiceRequest $request)
    {

        $shop_id = Auth::id();
        $date = $request->date ?? '';
        $invoice_no = $request->invoice_no ?? '';
        $times = $request->times ?? '';

        $forbidden = WarehouseStockItemForbidden::checkModifyPermission($date);

        if($forbidden > 0){
            return response()->json(array(
                'code' => 403,
                'error' => '該日期已禁止修改!',
            ));
        }

        if ($date){
            //格式:20220429
            $date = Carbon::parse($request->input('date'))->isoFormat('YMMDD');

            DB::table('warehouse_stock_items')
                ->where('user_id', $shop_id)
//                ->where('date', $date)
                ->where('times', $times )
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

    //查詢價格
    public function price_check(Request $request)
    {
        $date = $request->input('date');

        $prices = WarehouseProductPrice::query()
            ->whereDate('start_date','<=', $date)
            ->whereDate('end_date','>=', $date)
            ->get(['product_id', 'price', 'base_price']);


        return response()->json(array(
            'code' => 200,
            'prices' => $prices,
        ));
    }
}
