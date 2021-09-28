<?php

use App\Models\ShopGroup;
use Carbon\Carbon;

function getReportShop(){
    return ShopGroup::all()->pluck('name','id');
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

function isDateBetween($start_date, $end_date, $check_date)
{
    $start = Carbon::parse($start_date);
    $end = Carbon::parse($end_date);
    $check = Carbon::parse($check_date);

    return $check->between($start, $end);
}

/**
 * 判断两个时间范围是否有交集
 * 參考 https://blog.csdn.net/HXNLYW/article/details/102701632
 * @param $check_start_date  比较时间段开始时间
 * @param $check_end_date    比较时间段结束时间
 * @param $start_date        参考时间段开始时间
 * @param $end_date          参考时间段结束时间
 * @param $included          時間是否可以相等
 * @return
 */
function checkTimesHasOverlap($check_start_date, $check_end_date, $start_date, $end_date, $included = true) {

    $check_start = Carbon::parse($check_start_date);
    $check_end = Carbon::parse($check_end_date);
    $start = Carbon::parse($start_date);
    $end = Carbon::parse($end_date);

    if($included){
        return !( $check_end->lt($start) || $check_start->gt($end) );
    }else{
        return !( $check_end->lte($start) || $check_start->gte($end) );
    }


}
