<?php

namespace App\Http\Controllers;


use App\Models\Supplier\Supplier;
use App\Models\Supplier\SupplierStockItemList;
use App\Models\SupplierGroup;
use App\Models\WarehouseGroup;
use App\Models\WarehouseProduct;
use App\Models\WarehouseStockItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

//        $front_group_id = Auth::user()->front_groups->first()->id;
//        $product_list = SupplierStockItemList::where('front_group_id', $front_group_id)
//            ->first();
//        dump($product_list->toArray());

        $product_ids = WarehouseProduct::where('status', 0)->get()->pluck('id');

//        $products = [];
//        $groups = [];
//        $suppliers = [];
//        if(isset($product_list->item_list)){
//            $product_ids = explode(',', $product_list->item_list);
        $products = WarehouseProduct::getProducts($product_ids, $warehouse_group, $supplier, $search, $type, $date);

        $groups = SupplierGroup::whereHas('warehouse_products', function ($query) use($product_ids){
            $query->whereIn('id', $product_ids);
        })->pluck('name', 'id')->toArray();

        $warehouse_groups = WarehouseGroup::whereHas('warehouse_products', function ($query) use($product_ids){
            $query->whereIn('id', $product_ids);
        })->pluck('name', 'id')->toArray();

        $suppliers = Supplier::whereHas('warehouse_products', function ($query) use($product_ids){
            $query->whereIn('id', $product_ids);
        })->pluck('name', 'id')->toArray();

//        dump($warehouse_groups);

//        dump($groups);
//        dump($suppliers);
//            dump($products->toArray());
//        }

        //格式:20220429
        $currentdate = Carbon::now()->subDays(self::DELAY_DAY)->isoFormat('YMMDD');
        $date = Carbon::parse($request->input('date'))->isoFormat('YMMDD') ?? $currentdate;
        $stockitems = WarehouseStockItem::all()
            ->where('user_id', Auth::id())
            ->where('date', $date)
            ->pluck('qty','product_id')
            ->toArray();

        $stockitem_units = WarehouseStockItem::all()
            ->where('user_id', Auth::id())
            ->where('date', $date)
            ->pluck('unit_id','product_id')
            ->toArray();

//        dump($date);
//        dump($products->toArray());

        return view('warehouse_stock.index', compact('products',
            'groups',
            'warehouse_groups',
            'suppliers',
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
}
