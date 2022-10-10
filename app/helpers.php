<?php

use App\Models\ShopGroup;
use App\Models\ShopSubGroup;
use Carbon\Carbon;

function getReportShop(){
    return ShopGroup::all()->pluck('name','id');
}

function getReportShopByIDs(array $ids){
    return ShopGroup::query()->whereIn('id', $ids)->get()->pluck('name','id');
}

//2022-09-02 查詢子分組數組
function getSubGroup(){
    return ShopSubGroup::query()
        ->with('shop_group')
        ->get()
        ->mapWithKeys(function ($item, $key) {
            return [$item['id'] => $item['shop_group']['name'].'->'.$item['name']];
        });
}

function getStartTime(){
    if(isset($_REQUEST['between']['start'])){
        $start = $_REQUEST['between']['start'];
    }else{
        //上个月第一天
        $start = Carbon::now()->subMonth()->firstOfMonth()->toDateString();
    }
    return $start;
}

function getEndTime(){
    if(isset($_REQUEST['between']['end'])){
        $end = $_REQUEST['between']['end'];
    }else{
        //上个月最后一天
        $end = Carbon::now()->subMonth()->lastOfMonth()->toDateString();
    }
    return $end;
}

function getStartTimeWithoutDefault(){
    return $_REQUEST['between']['start'] ?? '';
}

function getEndTimeWithoutDefault(){
    return $_REQUEST['between']['end'] ?? '';
}

function getMonth()
{
    if (isset($_REQUEST['month']) && $_REQUEST['month'] != '') {
        $month = $_REQUEST['month'];
    } else {
        //上个月最后一天
        $month = Carbon::now()->subMonth()->isoFormat('Y-MM');
    }
    return $month;
}

//PHP自动给URl添加http://前缀
//https://blog.csdn.net/qq_27968607/article/details/51744874
function fixUrl($url, $def = false, $prefix = false)
{
    $url = trim($url);
    if (empty($url)) {
        return $def;
    }

    if (count(explode('://', $url)) > 1) {
        return $url;
    } else {
        return $prefix === false ? 'http://' . $url : $prefix . $url;
    }
}

//獲取需要發送通知的Email
function getNotificationEmails(string $type = '')
{
    $is_test = isTestEnvironment();

    return \App\Models\NotificationEmail::query()->where([
        'type'      => $type,
        'is_test'   => $is_test,
    ])->get(['name', 'email']);

}

//獲取需要發送通知的Email
function isTestEnvironment()
{
    if(app()->environment('local')){
        $is_test = 1;
    }

    if(app()->environment('production')){
        $is_test = 0;
    }

    return $is_test;

}

function getRequestDateOrNow($date){

    return $date ? Carbon::parse($date)->toDateString() : Carbon::now()->toDateString();
}
