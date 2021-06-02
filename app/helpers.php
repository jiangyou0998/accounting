<?php

use App\Models\ShopGroup;

function getReportShop(){
    return ShopGroup::all()->pluck('name','id');
}
