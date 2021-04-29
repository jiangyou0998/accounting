<?php

namespace App\Http\Controllers;

use App\Models\WorkshopCartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

        $items = WorkshopCartItem::query()
            ->with('products','unit')
            ->select('product_id')
            ->notDeleted()
            ->whereBetween('deli_date' , ['2021-01-01','2021-04-30'])
            ->where(function($query) {
                $query->where('qty_received', '>' , 0)
                    ->orWhere('qty', '>' , 0);
            })
            ->where('user_id', Auth::id())
            ->groupBy('product_id')
            ->get();

//        dump($items->toArray());
        return view('stock.index' , compact('items'));
    }
}
