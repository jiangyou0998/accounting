<?php

namespace App\Http\Controllers;

use App\Models\Supplier\SupplierProduct;
use App\Models\Supplier\SupplierStockItemList;
use App\Models\WorkshopCartItem;
use App\Models\WorkshopGroup;
use App\Models\WorkshopProduct;
use App\Models\WorkshopUnit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierStockController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

        $product_list = SupplierStockItemList::where('user_id', Auth::user()->id)
            ->where('month', Carbon::now()->isoFormat('YMM'))
            ->first();
//        dump($product_list->toArray());

        $product_ids = json_decode($product_list->item_list,true);

        $products = SupplierProduct::getProducts($product_ids);

//        dd($products->toArray());

        return view('stock.supplier_index', compact('products'));
    }
}
