<?php

namespace App\Http\Controllers;

use App\Models\WorkshopCartItem;
use App\Models\WorkshopGroup;
use App\Models\WorkshopProduct;
use App\Models\WorkshopUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierStockController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

        return view('stock.supplier_index');
    }
}
