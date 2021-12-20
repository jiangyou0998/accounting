<?php

namespace App\Http\Controllers;


use App\Models\StockItem;
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
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request){

        $group = $request->group ?? '';
        $search = $request->search ?? '';

        $front_group_id = Auth::user()->front_groups->first()->id;
        $product_list = SupplierStockItemList::where('front_group_id', $front_group_id)
            ->first();
//        dump($product_list->toArray());

        $products = [];
        $groups = [];
        $suppliers = [];
        if(isset($product_list->item_list)){
            $product_ids = explode(',', $product_list->item_list);
            $products = SupplierProduct::getProducts($product_ids, $group, $search);

            $groups = SupplierGroup::whereHas('products', function ($query) use($product_ids){
                $query->whereIn('id', $product_ids);
            })->pluck('name', 'id')->toArray();

            $suppliers = Supplier::whereHas('products', function ($query) use($product_ids){
                $query->whereIn('id', $product_ids);
            })->pluck('name', 'id')->toArray();

            //        dump($product_ids);

//        dump($groups);
//        dump($suppliers);
//        dd($products->toArray());
        }

        //格式:202104
        $currentmonth = Carbon::now()->isoFormat('YMM');
        $month = $request->input('month') ?? $currentmonth;
        $stockitems = SupplierStockItem::all()
            ->where('user_id', Auth::id())
            ->where('month', $month)
            ->pluck('qty','product_id')
            ->toArray();

        return view('stock.supplier_index', compact('products', 'groups', 'suppliers', 'stockitems'));
    }

    public function add(Request $request)
    {
        //格式:202104
        $currentmonth = Carbon::now()->isoFormat('YMM');
        $user = $request->user();
        $product_id = $request->input('product_id');
        $month = $request->input('month') ?? $currentmonth;
        $qty = $request->input('qty');

        // 从数据库中查询该商品是否已经在购物车中
        if ($stock = SupplierStockItem::query()
            ->where('product_id', $product_id)
            ->where('user_id', $user->id)
            ->where('month', $month)
            ->first()) {

            // 如果存在则直接叠加商品数量
            $stock->update([
                'qty' => $qty,
            ]);
        } else {

            // 否则创建一个新的购物车记录
            $stock = new SupplierStockItem(['qty' => $qty]);
            $stock->product_id = $product_id;
            $stock->user_id = $user->id;
            $stock->month = $month;
            $stock->save();
        }

        return [];
    }
}
