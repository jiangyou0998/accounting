<?php

namespace App\Admin\Traits;

use App\Models\WorkshopCartItem;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

trait InvoiceTraits
{
    //查詢客戶po數組
    public function getCustomerPoArr()
    {
        $customerPoArr = array();
        $customer_pos = DB::table('customer_pos')->get();
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
        if(isset($request->deli_date)){
            $deli_date = $request->deli_date;
        }else{
            $deli_date = $now->toDateString();
        }

        //根據權限獲取商店id
        $shopids = $request->shop ?? 0;

        $shopIDArr = explode('-',$shopids);

        $allData = array();

        foreach ($shopIDArr as $shopid){
            //送貨單詳細數據
            $details = WorkshopCartItem::getDeliDetail($deli_date, $shopid, $type);
            //合計數據
            $totals = WorkshopCartItem::getDeliTotal($deli_date, $shopid, $type);
//        dump($details->toArray());
//        dump($totals->toArray());

            $total = (float)0;
            foreach ($totals as $v){
                $total += $v->total;
            }
//        dump($total);

            $user = User::with('address')->find($shopid);
            $address = $user->address;

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
            $infos->total = $total;
//        $infos->total_english = $this->money_to_english($total);
            $infos->pocode = $user->pocode.Carbon::parse($deli_date)->isoFormat('YYMMDD');
            $infos->customer_po = $this->getCustomerPo($shopid ,$deli_date);
            //2021-03-01 每頁item數寫進常量
            $infos->item_count = self::ITEM_COUNT_PER_PAGE;
//        dump($infos->shop_info->toArray());
//        dump($infos->total_english);
            $allData[$shopid]['details'] = $details;
            $allData[$shopid]['totals'] = $totals;
            $allData[$shopid]['infos'] = $infos;
        }
//        dump($allData);
        return $allData;
    }
}
