<?php

namespace App\Http\Controllers;

use App\Models\StockItem;
use App\Models\WorkshopGroup;
use App\Models\WorkshopProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    //可以推遲幾天提交
    const DELAY_DAY = 7;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request){

        $group = $request->group ?? '';
        $search = $request->search ?? '';

        $productModel = WorkshopProduct::query()
            ->with('unit')
            ->whereHas('cartitems', function ($query){
                $query->notDeleted()
                    ->lastMonths(4)
                    ->hasQty()
                    ->where('user_id', Auth::id());
            })
            ->OfGroup($group)
            ->OfSearch($search)
            ->groupBy('id')
            ->orderBy('product_no')
            ->get();

        $products = $productModel->mapToGroups(function ($item, $key) {
            return [$item['group_id'] => $item];
        });

        $product_ids = WorkshopProduct::query()
            ->whereHas('cartitems', function ($query) {
                $query->notDeleted()
                    ->lastMonths(4)
                    ->hasQty()
                    ->where('user_id', Auth::id());
            })->pluck('id');

        $groups = WorkshopGroup::whereHas('products', function ($query) use($product_ids){
            $query->whereIn('id', $product_ids);
        })->pluck('group_name', 'id')->toArray();

        //格式:202104
        $currentmonth = Carbon::now()->subDays(self::DELAY_DAY)->isoFormat('YMM');
        $month = $request->input('month') ?? $currentmonth;
        $stockitems = StockItem::all()
            ->where('user_id', Auth::id())
            ->where('month', $month)
            ->pluck('qty','product_id')
            ->toArray();

        $stockitem_units = StockItem::all()
            ->where('user_id', Auth::id())
            ->where('month', $month)
            ->pluck('unit_id','product_id')
            ->toArray();

        $monthname = Carbon::now()->subDays(self::DELAY_DAY)->monthName;

//        dump($stockitems);
//        dump($product_ids);
//        dump($groups);
        return view('stock.index' , compact('products', 'groups', 'stockitems', 'stockitem_units', 'monthname'));
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
        if ($stock = StockItem::query()
            ->where('product_id', $product_id)
            ->where('user_id', $user->id)
            ->where('month', $month)
            ->first()) {

            // 如果存在则直接叠加商品数量
            $stock->update([
                'qty' => $qty,
                'unit_id' => $unit_id,
            ]);
        } else {

            // 否则创建一个新的购物车记录
            $stock = new StockItem(['qty' => $qty, 'unit_id' => $unit_id]);
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
        StockItem::query()
            ->where('product_id', $product_id)
            ->where('user_id', $user->id)
            ->where('month', $month)
            ->delete();

        return [];
    }
}
