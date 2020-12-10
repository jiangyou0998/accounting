<?php

namespace App\Admin\Controllers;

use App\Exports\SalesByShopAndMenuExport;
use App\Http\Controllers\Controller;
use App\Models\ShopGroup;
use App\Models\WorkshopCat;
use App\Models\WorkshopGroup;
use App\Models\WorkshopUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ApiController extends Controller
{
    public function group(Request $request)
    {
        $catId = $request->get('q');
//        $groupId = 150;
//        dd($catId);

        return WorkshopGroup::where('cat_id', $catId)->get(['id', DB::raw('group_name as text')])->prepend(['id' => '','text'=>'全部']);
    }

    public function cat()
    {

        return WorkshopCat::orderBy('sort')->get(['id', DB::raw('cat_name as text')]);
    }

    public function group2()
    {

        return WorkshopGroup::get(['id', DB::raw('group_name as text')]);
    }

    public function unit()
    {

        return WorkshopUnit::get(['id', DB::raw('unit_name as text')]);
    }

    public function shop_group()
    {
        return ShopGroup::get(['id', DB::raw('name as text')]);
    }

    public function test()
    {
        return view('admin.order_print.index');
    }


}
