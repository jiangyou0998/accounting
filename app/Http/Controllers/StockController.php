<?php

namespace App\Http\Controllers;

use App\Models\WorkshopCartItem;
use App\Models\WorkshopGroup;
use App\Models\WorkshopProduct;
use App\Models\WorkshopUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

//        $products = WorkshopCartItem::query()
//            ->with('products','unit')
//            ->select('product_id')
//            ->notDeleted()
//            ->lastMonths(4)
//            ->hasQty()
//            ->where('user_id', Auth::id())
//            ->groupBy('product_id')
//            ->get();
//
//        dump($products);

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
//        dd($products->toArray());
        $products = $productModel->mapToGroups(function ($item, $key) {
            return [$item['group_id'] => $item];
        });

        $groups = WorkshopGroup::all()->pluck('group_name', 'id')->toArray();
//        $units = WorkshopUnit::all()->pluck('unit_name', 'id')->toArray();

//        dump($groups);
//        dump($units);
//        dump($products2->toArray());
//        return 111;
        return view('stock.index' , compact('products', 'groups'));
    }
}
