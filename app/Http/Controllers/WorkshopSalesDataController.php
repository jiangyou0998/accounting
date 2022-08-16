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
use App\Models\ShopSubGroup;
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

        $shop_sub_groups = ShopSubGroup::query()
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

        //下級分類總計(Lagardere拆分的分組)
        $sub_group_total_today = WorkshopCartItem::getSubGroupTotal($date, $date);
        $sub_group_total_this_month = WorkshopCartItem::getSubGroupTotal($start_of_month, $date);

        //有下級分組的價格分組
        $exclude_shop_groups = ShopSubGroup::query()->pluck('shop_group_id')->toArray();

        return view('workshop_sales_data.report', compact(
            'sale_summary',
            'shop_groups',
            'shop_sub_groups',
            'exclude_shop_groups',
            'customer_total_today',
            'customer_total_this_month',
            'sub_group_total_today',
            'sub_group_total_this_month',
            'date',
            'date_and_week')
        );
    }


}
