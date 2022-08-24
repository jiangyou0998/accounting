<?php

namespace App\Http\Controllers\FrontReport;

use App\Http\Controllers\Controller;
use App\Models\KB\KBWorkshopCartItem;
use App\Models\KB\KBWorkshopProduct;
use App\Models\KB\KBWorkshopUnit;
use App\Models\ShopGroup;
use App\User;
use Illuminate\Http\Request;

class TopSalesReportController extends Controller
{
    //
    public function report(Request $request){

        $start_date = $request->start_date ?? now()->toDateString();
        $end_date = $request->end_date ?? now()->toDateString();
        $shop_ids = $request->shop_ids;
        $limit = $request->limit ?? 15;

        $shops = User::getShopsByShopGroup(ShopGroup::CURRENT_SHOP_ID);

        $products = KBWorkshopCartItem::getItemsByDateRange($start_date, $end_date, $shop_ids, $limit);

        $productInfosArr = KBWorkshopProduct::getProductInfoAndID();

        $unitInfoArr = KBWorkshopUnit::getUnitInfoAndID();

//        dump($products->toArray());
//        dump($productInfosArr);
//        dump($unitInfoArr);
//        dump($shops);

        return view('front_reports.top_sales.report', compact('products', 'shops', 'productInfosArr', 'unitInfoArr'));

    }
}
