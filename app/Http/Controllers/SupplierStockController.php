<?php

namespace App\Http\Controllers;


use App\Models\Supplier\Supplier;
use App\Models\Supplier\SupplierProduct;
use App\Models\Supplier\SupplierStockItemList;
use App\Models\SupplierGroup;
use App\Models\SupplierStockItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierStockController extends Controller
{
    //可以推遲幾天提交
    const DELAY_DAY = 10;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request){

        $group = $request->group ?? '';
        $supplier = $request->supplier ?? '';
        $search = $request->search ?? '';
        $type = $request->type ?? '';

        //格式:202104
        $currentmonth = Carbon::now()->subDays(self::DELAY_DAY)->isoFormat('YMM');
        $month = $request->input('month') ?? $currentmonth;

        $front_group_id = Auth::user()->front_groups->first()->id;
        $product_list = SupplierStockItemList::where('front_group_id', $front_group_id)
            ->first();
//        dump($product_list->toArray());

        $products = [];
        $groups = [];
        $suppliers = [];
        if(isset($product_list->item_list)){
            $product_ids = explode(',', $product_list->item_list);
            $products = SupplierProduct::getProducts($product_ids, $group, $supplier, $search, $type, $month);

            $groups = SupplierGroup::whereHas('products', function ($query) use($product_ids){
                $query->whereIn('id', $product_ids);
            })->pluck('name', 'id')->toArray();

            $suppliers = Supplier::whereHas('products', function ($query) use($product_ids){
                $query->whereIn('id', $product_ids);
            })->pluck('name', 'id')->toArray();

//                    dump($product_ids);

//        dump($groups);
//        dump($suppliers);
//            dump($products->toArray());
        }

        $stockItemModel = SupplierStockItem::query()
            ->where('user_id', Auth::id())
            ->where('month', $month)
//            ->where('date', $date)
        ;

        $allstockitems = (clone $stockItemModel)->get();
        $stockitems = array();
        foreach ($allstockitems as $v){
            $stockitems[$v->product_id][$v->unit_id] = $v->qty;
        }

//        dump($stockitems);

//        $stockitems = SupplierStockItem::all()
//            ->where('user_id', Auth::id())
//            ->where('month', $month)
//            ->pluck('qty','product_id')
//            ->toArray();

        $stockitem_units = (clone $stockItemModel)
            ->pluck('unit_id','product_id')
            ->toArray();

        $monthname = Carbon::now()->subDays(self::DELAY_DAY)->monthName;
//        dump($stockitem_units);

        //打印模式
        $mode = $request->mode ?? '';

        if($mode === 'print'){
            return view('stock.supplier_print', compact('products',
                    'groups',
                    'suppliers',
                    'stockitems',
                    'stockitem_units',
                    'monthname')
            );
        }else{
            return view('stock.supplier_index', compact('products',
                    'groups',
                    'suppliers',
                    'stockitems',
                    'stockitem_units',
                    'monthname')
            );
        }


    }

    public function add(Request $request)
    {
        //格式:202104
        $currentmonth = Carbon::now()->subDays(self::DELAY_DAY)->isoFormat('YMM');
        $user = $request->user();
        $product_id = $request->input('product_id');
        $month = $request->input('month') ?? $currentmonth;
        $qty = $request->input('qty');
        $unit_id = $request->input('unit_id');

        // 从数据库中查询该商品是否已经在购物车中
        if ($stock = SupplierStockItem::query()
            ->where('product_id', $product_id)
            ->where('user_id', $user->id)
            ->where('month', $month)
            ->where('unit_id', $unit_id)
            ->first()) {

            // 如果存在则直接叠加商品数量
            $stock->update([
                'qty' => $qty,
                'unit_id' => $unit_id,
            ]);
        } else {

            // 否则创建一个新的购物车记录
            $stock = new SupplierStockItem(['qty' => $qty, 'unit_id' => $unit_id]);
            $stock->product_id = $product_id;
            $stock->user_id = $user->id;
            $stock->month = $month;
            $stock->save();
        }

        return [];
    }

    public function delete(Request $request)
    {
        //格式:202104
        $currentmonth = Carbon::now()->subDays(self::DELAY_DAY)->isoFormat('YMM');
        $user = $request->user();
        $product_id = $request->input('product_id');
        $month = $request->input('month') ?? $currentmonth;


        // 刪除數據
        SupplierStockItem::query()
            ->where('product_id', $product_id)
            ->where('user_id', $user->id)
            ->where('month', $month)
            ->delete();

        return [];
    }
}
