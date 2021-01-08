<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Price;
use App\Models\WorkshopProduct;
use Carbon\Carbon;

class DataChangeApiController extends Controller
{
    //複製product表數據到price表(糧友限定)
    public function copyProductToPrice(){
        $products = WorkshopProduct::all();

        $pricesArr = array();
        $now = Carbon::now()->toDateTimeString();
        foreach ($products as $product){
            $price['product_id'] = $product->id;
            //蛋撻王shop_group_id為1
            $price['shop_group_id'] = 5;
            $price['price'] = $product->default_price;
            $price['cuttime'] = $product->cuttime;
            $price['phase'] = $product->phase;
            $price['canordertime'] = $product->canordertime;
            $price['base'] = $product->base;
            $price['min'] = $product->min;
            $price['created_at'] = $now;
            $price['updated_at'] = $now;
            $pricesArr[] = $price;
        }
//        dump($pricesArr);
        Price::insert($pricesArr);
    }

}
