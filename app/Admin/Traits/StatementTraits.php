<?php

namespace App\Admin\Traits;

use App\Models\WorkshopCartItem;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

trait StatementTraits
{
    public function getStatementData(Request $request)
    {
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

        $month = $this->getMonth();

        foreach ($shopIDArr as $shopid) {
            $datas = $this->generateStatement($month, $shopid);
//        dump($datas->toArray());

            $total = (float)0;
            foreach ($datas as $data) {
                $total += $data->Total;
            }
//        dump($total);
//        dump($details->toArray());
//        dump($totals->toArray());

            $user = User::with('address')->find($shopid);
            $address = $user->address;

            $start_date = (new Carbon($month))->firstOfMonth()->toDateString();
            $end_date = (new Carbon($month))->endOfMonth()->toDateString();

            //頁面顯示數據
            $infos = new Collection();
            $infos->deli_date = $deli_date;
            $infos->shop = $shopid;
            $infos->shop_name = $user->txt_name;
            $infos->now = $now->toDateTimeString();
            $infos->start_date = $start_date;
            $infos->end_date = $end_date;
            $infos->company_name = $user->company_english_name ?? '';
            $infos->address = $address->address ?? '';
            $infos->phone = $address->tel ?? '';
            $infos->fax = $address->fax ?? '';
            $infos->total = $total;
            $infos->pocode_prefix = $user->pocode;

            $allData[$shopid]['datas'] = $datas;
            $allData[$shopid]['infos'] = $infos;
        }
//        dd($allData);
        return $allData;
    }
}
