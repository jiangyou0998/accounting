<?php

namespace App\Http\Controllers;

use App\Models\StockItem;
use App\Models\WorkshopCartItem;
use App\Models\WorkshopGroup;
use App\Models\WorkshopProduct;
use App\Models\WorkshopUnit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request){

        $productModel = WorkshopProduct::query()
            ->with('units')
            ->whereHas('cartitems', function ($query){
                $query->notDeleted()
                    ->lastMonths(4)
                    ->hasQty()
                    ->where('user_id', Auth::id());
            })
            ->groupBy('id')
            ->orderBy('product_no')
            ->get();

        $products = $productModel->mapToGroups(function ($item, $key) {
            return [$item['group_id'] => $item];
        });

        $groups = WorkshopGroup::all()->pluck('group_name', 'id')->toArray();

        //格式:202104
        $lastmonth = Carbon::now()->subMonth()->isoFormat('YMM');
        $month = $request->input('month') ?? $lastmonth;
        $stockitems = StockItem::all()
            ->where('user_id', Auth::id())
            ->where('month', $month)
            ->pluck('qty','product_id')
            ->toArray();

//        dump($stockitems);
//        dump($groups);
        return view('stock.index' , compact('products', 'groups', 'stockitems'));
    }

    public function add(Request $request)
    {
        //格式:202104
        $lastmonth = Carbon::now()->subMonth()->isoFormat('YMM');
        $user = $request->user();
        $product_id = $request->input('product_id');
        $month = $request->input('month') ?? $lastmonth;
        $qty = $request->input('qty');

        // 从数据库中查询该商品是否已经在购物车中
        if ($stock = StockItem::query()
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
            $stock = new StockItem(['qty' => $qty]);
            $stock->product_id = $product_id;
            $stock->user_id = $user->id;
            $stock->month = $month;
            $stock->save();
        }

        return [];
    }
}
