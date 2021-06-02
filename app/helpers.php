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
