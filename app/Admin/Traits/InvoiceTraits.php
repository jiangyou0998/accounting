<?php

namespace App\Admin\Traits;

use App\Models\CustomerPo;
use App\Models\WorkshopCartItem;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

trait InvoiceTraits
{
    //查詢客戶po數組
    public function getCustomerPoArr($shop_ids = null)
    {
        $customerPoArr = array();
        $customer_pos = CustomerPo::query()->ofShopIds($shop_ids)->get();
        foreach ($customer_pos as $customer_po){
            $customerPoArr[$customer_po->shop_id][$customer_po->deli_date] = $customer_po->po;
        }
        return $customerPoArr;
    }

    //查詢Invoice的客戶po
    public function getCustomerPo($shop_id, $deli_date)
    {
        $customer_po = DB::table('customer_pos')
            ->where('shop_id', $shop_id)
            ->where('deli_date', $deli_date)
            ->first();

        return $customer_po->po ?? '';
    }

    public function getInoviceData(Request $request)
    {
        $type = $request->type ?? null;
        $now = Carbon::now();
        //如果URL沒有送貨日期,使用當日日期
        $deli_date_start = $request->deli_date ?? $now->toDateString();
        //2022-08-26 如沒有結束日期, 結束日期為開始日期同一日
        $deli_date_end = $request->deli_date_end ?? $deli_date_start;
        $deli_date_start_carbon = Carbon::parse($deli_date_start);
        $deli_date_end_carbon = Carbon::parse($deli_date_end);

        //根據權限獲取商店id
        $shop_ids = $request->shop ?? 0;

        $shopIDArr = explode('-',$shop_ids);

        $allData = array();

        $shop_count = count($shopIDArr);
        $days_count = $deli_date_end_carbon->diffInDays($deli_date_start_carbon) + 1;
        $serach_count = $shop_count * $days_count;

        if($serach_count > 62){
            abort(403, '需要查詢數據過多，為防止服務器崩潰，本次查詢取消');
        }

        $details = WorkshopCartItem::getInvoiceDetail($deli_date_start, $deli_date_end, $shop_ids, $type);
        $totals = WorkshopCartItem::getInvoiceTotal($deli_date_start, $deli_date_end, $shop_ids, $type);
        $users = User::with('address')
            ->whereIn('id', $shopIDArr)
            ->get();

        $userArr = [];
        foreach ($users as $user){
            $userArr[$user->id] = $user;
        }

        $poArr = $this->getCustomerPoArr($shop_ids);
//        dump($poArr);
//        dump($userArr);
//        dump($details);
//        dd($totals);
        foreach ($details as $shopid => $date_details){
            foreach ($date_details as $deli_date => $detail) {
                $user = $userArr[$shopid];
                $address = $user->address;

//            while($deli_date_end_carbon->gte($time)) {

                //送貨單詳細數據

                //合計數據
//                $totals = WorkshopCartItem::getDeliTotal($deli_date, $shopid, $type);
//        dump($details->toArray());
//        dump($totals->toArray());

//        dump($total);

                //頁面顯示數據
                $infos = new Collection();
                $infos->deli_date = $deli_date;
                $infos->shop = $shopid;
                $infos->shop_name = $user->txt_name;
                $infos->now = $now->toDateTimeString();
                $infos->company_name = $user->company_english_name ?? '';
                $infos->address = $address->address ?? '';
                $infos->phone = $address->tel ?? '';
                $infos->fax = $address->fax ?? '';
                $infos->total = $totals[$shopid][$deli_date]['total'];
//        $infos->total_english = $this->money_to_english($total);
                $infos->pocode = $user->pocode.Carbon::parse($deli_date)->isoFormat('YYMMDD');
                $infos->customer_po = $poArr[$shopid][$deli_date] ?? '';
                //2021-03-01 每頁item數寫進常量
                $infos->item_count = self::ITEM_COUNT_PER_PAGE;

                //2021-11-23 訂單如果修改過 revised標記為true
                $infos->revised = false;
                if(count($detail) > 0){
                    foreach ($detail as $v){
                        if($v->qty != $v->qty_received){
                            $infos->revised = true;
                            break;
                        }
                    }
                }

//        dump($infos->shop_info->toArray());
//        dump($infos->total_english);
                $allData[$shopid][$deli_date]['details'] = $detail;
                $allData[$shopid][$deli_date]['totals'] = $totals[$shopid][$deli_date];
                $allData[$shopid][$deli_date]['infos'] = $infos;
            }
        }
//        dd($allData);
        return $allData;
    }
}
