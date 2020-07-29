<?php

namespace App\Admin\Controllers;

use App\Exports\SalesByShopAndMenuExport;
use App\Http\Controllers\Controller;
use App\Models\ShopGroup;
use App\Models\TblOrderZCat;
use App\Models\TblOrderZGroup;
use App\Models\TblOrderZUnit;
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

        return TblOrderZGroup::where('int_cat', $catId)->get([DB::raw('int_id as id'), DB::raw('chr_name as text')]);
    }

    public function cat()
    {

        return TblOrderZCat::get([DB::raw('int_id as id'), DB::raw('chr_name as text')]);
    }

    public function group2()
    {

        return TblOrderZGroup::get([DB::raw('int_id as id'), DB::raw('chr_name as text')]);
    }

    public function unit()
    {

        return TblOrderZUnit::get([DB::raw('int_id as id'), DB::raw('chr_name as text')]);
    }

    public function shop_group()
    {
        return ShopGroup::get(['id', DB::raw('name as text')]);
    }

    public function export()
    {
//        return Excel::download(new SalesByShopAndMenuExport(), 'users.xls');
//        Excel::assertDownloaded('filename.xlsx', function(SalesByShopAndMenuExport $export) {
//            // Assert that the correct export is downloaded.
//            return $export->collection()->contains('#2018-01');
//        });

        (new SalesByShopAndMenuExport)->download('invoices.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

}
