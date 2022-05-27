<?php

namespace App\Http\Controllers;


use App\Http\Requests\SalesDataRequest;
use App\Http\Traits\SalesDataTableTraits;
use App\Models\FrontGroupHasUser;
use App\Models\SalesBill;
use App\Models\SalesCalResult;
use App\Models\SalesIncomeDetail;
use App\Models\SalesIncomeType;
use App\Models\ShopGroup;
use App\Models\ShopGroupHasUser;
use App\Models\WorkshopCartItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

//前台顯示工場批發總數
class WorkshopSalesDataController extends Controller
{
    //手機顯示營業數頁面
    public function report(Request $request)
    {
        $date = $request->date ?? Carbon::now()->toDateString();
        $date_and_week = Carbon::parse($date)->isoFormat('YYYY/MM/DD(dd)');

        $shop_groups = ShopGroup::query()
            ->where('id', '!=', 1)
            ->orderBy('sort')
            ->pluck('name', 'id')
            ->toArray();

        $start_of_month = Carbon::parse($date)->startOfMonth()->toDateString();
        //今日外客批發數
        $customer_total_today = WorkshopCartItem::getCustomerTotal($date, $date);
        //本月外客批發數
        $customer_total_this_month = WorkshopCartItem::getCustomerTotal($start_of_month, $date);

        //計算所有總數
        $sale_summary['total'] = 0;
        $sale_summary['month_total'] = 0;

        $sale_summary['total'] = $customer_total_today->sum();
        $sale_summary['month_total'] = $customer_total_this_month->sum();

        $customer_total_today = $customer_total_today->toArray();
        $customer_total_this_month = $customer_total_this_month->toArray();

        $jichang_ids = [127,128,129,130];
        $jichang_today = WorkshopCartItem::getCustomerTotalByIDs($date, $date, $jichang_ids);
        $jichang_this_month = WorkshopCartItem::getCustomerTotalByIDs($start_of_month, $date, $jichang_ids);

        $hongkan_ids = [169,170];
        $hongkan_today = WorkshopCartItem::getCustomerTotalByIDs($date, $date, $hongkan_ids);
        $hongkan_this_month = WorkshopCartItem::getCustomerTotalByIDs($start_of_month, $date, $hongkan_ids);


        return view('workshop_sales_data.report', compact(
            'sale_summary',
            'shop_groups',
            'customer_total_today',
            'customer_total_this_month',
            'jichang_today',
            'jichang_this_month',
            'hongkan_today',
            'hongkan_this_month',
            'date',
            'date_and_week')
        );
    }


}
