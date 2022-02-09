<?php

namespace App\Http\Controllers;


use App\Models\ShopGroup;
use App\Models\ShopGroupHasUser;
use App\Models\WorkshopCartItem;
use App\Models\WorkshopCartItemLog;
use App\Models\WorkshopProduct;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SalesDataController extends Controller
{
    public function index()
    {
        $shop_group_ids = ShopGroup::all()->sortBy('sort')->pluck('name','id');
//        dd($shop_group_ids);
        return view('sales_data.index', compact('shop_group_ids'));
    }

}
