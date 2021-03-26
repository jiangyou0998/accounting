<?php

namespace App\Services\Order;

use App\Models\WorkshopCartItem;
use App\Models\WorkshopCartItemLog;
use App\Models\WorkshopGroup;
use App\Models\WorkshopProduct;
use App\Models\WorkshopSample;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class WorkshopCartItemService {

    public function update(Request $request, $shopid ,$user)
    {
        // 数据库事务处理
        DB::transaction(function () use ($user, $shopid, $request) {

            $insertDatas = json_decode($request->insertData, true);
            $updateDatas = json_decode($request->updateData, true);
            $delDatas = json_decode($request->delData, true);
            $ip = $request->ip();
            $cartItemModel = new WorkshopCartItem();
            $cartItemLogsModel = new WorkshopCartItemLog();
            $now = Carbon::now()->toDateTimeString();

//            dump($insertDatas);
//            dump($delDatas);
            $shop_group_id = User::getShopGroupId($shopid);

            //2021-01-06 下單時候價格改為從prices表獲取
            $prices = WorkshopProduct::with('prices')->whereHas('prices', function (Builder $query) use($shop_group_id){
                $query->where('shop_group_id', '=', $shop_group_id);
            })->get()->mapWithKeys(function ($item) use($shop_group_id){
                $price = $item['prices']->where('shop_group_id', $shop_group_id)->first()->price;
                return [$item['id'] => $price ];
            });
//            dump($prices);

            //新增
//            $insertArr = array();
            foreach ($insertDatas as $insertData) {
                //插入數據
                $insertArr = [
                    'order_date' => $now,
                    'user_id' => $shopid,
                    'product_id' => $insertData['itemid'],
                    'qty' => $insertData['qty'],
                    //2020-11-23 新增下單時候的價格
                    'order_price' => $prices[$insertData['itemid']],
                    'ip' => $ip,
                    'status' => 1,
//                    'po_no' => ,
                    'dept' => $insertData['dept'],
                    'insert_date' => $now,
                    'deli_date' => $insertData['deli_date']
                ];
                $cartItemId = $cartItemModel->insertGetId($insertArr);

                //寫入LOG
                $insertLogsArr= [
                    'operate_user_id' => $user->id,
                    'shop_id' => $shopid,
                    'product_id' => $insertData['itemid'],
                    'cart_item_id' => $cartItemId,
                    'method' => 'INSERT',
                    'ip' => $ip,
                    'input' => '新增數量'.$insertData['qty'].',價格:'.$prices[$insertData['itemid']],
                    'created_at' => $now,
                    'updated_at' => $now,
                ];

                $cartItemLogsModel->insert($insertLogsArr);

            }
//            dump($updateLogsArr);

            //更新
            $updateLogsArr = array();
            foreach ($updateDatas as $updateData) {
                $cartItemModel::where('id', $updateData['mysqlid'])->update(['qty' => $updateData['qty'] , 'order_date' => $now]);
//                $productModel = new WorkshopProduct();
                $updateLogsArr[] = [
                    'operate_user_id' => $user->id,
                    'shop_id' => $shopid,
                    'product_id' => $cartItemModel::find($updateData['mysqlid'])->product_id,
                    'cart_item_id' => $updateData['mysqlid'],
                    'method' => 'UPDATE',
                    'ip' => $ip,
                    'input' => '數量從' . $updateData['oldqty'] . '變為' . $updateData['qty'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            //插入更新LOG
            $cartItemLogsModel->insert($updateLogsArr);

            //刪除
            $delLogsArr = array();
            foreach ($delDatas as $delData) {
                $cartItemModel::where('id', $delData['mysqlid'])->update(['status' => 4]);
//                $productModel = new WorkshopProduct();
                $delLogsArr[] = [
                    'operate_user_id' => $user->id,
                    'shop_id' => $shopid,
                    'product_id' => $cartItemModel::find($delData['mysqlid'])->product_id,
                    'cart_item_id' => $delData['mysqlid'],
                    'method' => 'DELETE',
                    'ip' => $ip,
                    'input' => '刪除',
                    'created_at' => $now,
                    'updated_at' => $now,
                ];

            }

            //插入刪除LOG
            $cartItemLogsModel->insert($delLogsArr);

        });
    }

    public function getGroups($catid, Request $request)
    {
        $shop_id = $request->shop_id;
        $shop_group_id = User::getShopGroupId($shop_id);

        $groups = WorkshopGroup::where('cat_id', $catid)->whereHas('products', function (Builder $query) use($shop_group_id){
            $query->whereHas('prices', function (Builder $query) use($shop_group_id){
                $query->where('shop_group_id', '=', $shop_group_id);
            });
        })->get();

        return $groups;
    }

    public function getCartItemsAndCheckIsInvalid($shopid, $dept, $deli_date)
    {
        $items = WorkshopCartItem::getCartItems($shopid, $dept, $deli_date);

        foreach ($items as $item) {
            $this->checkInvalidOrder($item,$deli_date);
        }

        return $items;
    }

    public function getSampleItemsAndCheckIsInvalid($shopid , $dept , $deli_date, $item_count)
    {
        //送貨日期的星期几（格式:从0（星期日）到6（星期六））
        $deliW = Carbon::parse($deli_date)->isoFormat('d');
        $sampleItems = new Collection();
        if ($item_count == 0) {
            $sampleItems = WorkshopSample::getRegularOrderItems($shopid, $deliW ,$dept);
        }

        foreach ($sampleItems as $sampleItem) {
            $this->checkInvalidOrder($sampleItem,$deli_date);
        }

        return $sampleItems;
    }

    public function getOrderInfos($shopid , $dept, $deli_date, $dept_name)
    {
        $orderInfos = new Collection();
        $orderInfos->date = $deli_date;
        $orderInfos->shopid = $shopid;

        $orderInfos->shop_name = User::find($shopid)->txt_name;
        $orderInfos->dept = $dept;
        $orderInfos->dept_name = $dept_name;
        $orderInfos->deli_date = $deli_date;

        return $orderInfos;
    }

    public function getProducts($groupid ,$shop_group_id ,$deli_date)
    {
        $products = WorkshopProduct::with('cats')
            ->with('units')
            ->with('prices')
            ->where('group_id', $groupid)
            //2021-01-15 不顯示暫停產品
            ->whereNotIn('status', [2,4])
            //2021-01-13 根據dept設置分組
            ->whereHas('prices', function (Builder $query) use($shop_group_id){
                $query->where('shop_group_id', '=', $shop_group_id);
            })
            ->get();

        foreach ($products as $product) {
//            dump($deli_date.$product->cuttime);
            $productDetail = $product->prices->where('shop_group_id', '=', $shop_group_id)->first();

            $this->checkInvalidOrder($productDetail,$deli_date);

            $this->resetProduct($product,$productDetail);

//            dump(mb_substr($product->cats->cat_name,0,4));

        }

        return $products;
    }

    public function getProductInfos($groupid)
    {
        $group = WorkshopGroup::find($groupid);
        $infos = new Collection();
        $infos->group_name = $group->group_name;
        $infos->cat_name = $group->cats->cat_name;

        return $infos;
    }

    //判斷是否能下單
    //$product必須有phase,cuttime,canordertime
    private function checkInvalidOrder($product,$deli_date)
    {
        $product->order_by_workshop = false;
        $product->cut_order = false;
        $product->not_deli_time = false;

        //判斷是否後台落單
        if ($product->phase <= 0) {
            $product->order_by_workshop = true;
        }

        //判斷是否已截單
        if ($product->phase > 0) {
            $cuttime = $deli_date . " " . $product->cuttime . "00";
            $deliTime = Carbon::parse($cuttime)->subDay($product->phase);
            $now = Carbon::now();
            $product->cut_order = $deliTime->lt($now);
        }

        //判斷是否在出貨期
        $deliW = Carbon::parse($deli_date)->isoFormat('d');
        $canOrderTime = explode(",", $product->canordertime);
        //送貨日期不在可下單日期時
        if (!in_array($deliW, $canOrderTime)) {
            $product->not_deli_time = true;
        }

        //todo 判斷跳過週末不出貨

        //只要有一個是true,分店就不能下單
        $product->invalid_order =
            $product->order_by_workshop ||
            $product->cut_order ||
            $product->not_deli_time;
    }

    //將with數據(prices)拿到外層
    private function resetProduct($product, $productDetail)
    {
        $product->phase = $productDetail->phase;
        $product->cuttime = $productDetail->cuttime;
        $product->canordertime = $productDetail->canordertime;
        //2021-01-06 增加base,min
        $product->base = $productDetail->base;
        $product->min = $productDetail->min;

        $product->order_by_workshop = $productDetail->order_by_workshop;
        $product->cut_order = $productDetail->cut_order;
        $product->not_deli_time = $productDetail->not_deli_time;
        $product->invalid_order = $productDetail->invalid_order;
    }


}
