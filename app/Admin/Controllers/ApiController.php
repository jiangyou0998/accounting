<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ShopGroup;
use App\Models\TblOrderZCat;
use App\Models\TblOrderZGroup;
use App\Models\TblOrderZMenu;
use App\Models\TblOrderZUnit;
use App\Models\TblUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ApiController extends Controller
{
    public function group(Request $request)
    {
        $catId = $request->get('q');
//        $groupId = 150;
//        dd($catId);

        return TblOrderZGroup::where('int_cat', $catId)->get([DB::raw('int_id as id'), DB::raw('chr_name as text')])->prepend(['id' => '', 'text' => '全部']);
    }

    public function cat()
    {

        return TblOrderZCat::orderBy('int_sort')->get([DB::raw('int_id as id'), DB::raw('chr_name as text')]);
    }

    public function group2()
    {

        return TblOrderZGroup::get([DB::raw('int_id as id'), DB::raw('chr_name as text')]);
    }

    public function unit()
    {

        return TblOrderZUnit::get([DB::raw('int_id as id'), DB::raw('chr_name as text')]);
    }

    public function product_no()
    {
        return TblOrderZMenu::where('status', '!=', 4)->get([DB::raw('int_id as id'), DB::raw('concat(chr_no,\'-\',chr_name) as text')]);
    }

    public function kb_shop(){

        $users = new TblUser();
        $shops = $users->where('chr_type','=',2)
            ->where(function($query) {
                $query->where('txt_login','like','kb%')
                    ->orWhere('txt_login','like','ces%')
                    ->orWhere('txt_login','like','b&b%');
            })
            ->orderBy('txt_login')
            ->get([DB::raw('int_id as id'), DB::raw('txt_name as text')]);

        return $shops;
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
