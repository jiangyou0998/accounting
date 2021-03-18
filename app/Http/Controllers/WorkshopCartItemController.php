<?php

namespace App\Http\Controllers;


use App\Models\SpecialDate;
use App\Models\WorkshopCartItem;
use App\Models\WorkshopCartItemLog;
use App\Models\WorkshopCat;
use App\Models\WorkshopGroup;
use App\Models\WorkshopProduct;
use App\Models\WorkshopSample;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class WorkshopCartItemController extends Controller
{
    private $productArr;
    private $special_dates;

    public function update(Request $request, $shopid)
    {
        $user = Auth::User();

        if ($user->can('shop')) {
//            dump('shop');
            $shopid = $user->id;
        }
        if ($user->can('workshop')) {
//            dump('workshop');

        }
        if ($user->can('operation')) {
//            dump('operation');

        }

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
            $shop_group_id = 1;
            //2021-01-13 dept為RB 分組改為糧友
            if(request()->dept === 'RB') $shop_group_id = 5;

            //2020-11-23 新增下單時候的價格
//            $prices = WorkshopProduct::all()->pluck('default_price','id');
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

    //下單頁面
    public function cart(Request $request)
    {
        $user = Auth::User();

        $dept = $request->dept;

        //送貨日期(格式:2020-09-14)
        $deli_date = $request->deli_date;
        //送貨日期的星期几（格式:从0（星期日）到6（星期六））
        $deliW = Carbon::parse($deli_date)->isoFormat('d');

        if ($user->can('shop')) {
//            dump('shop');
            $shopid = $user->id;
            //分店無法修改明日之前的訂單
            if ($deli_date <= now()) {
//                return "權限不足";
                throw new AccessDeniedHttpException('權限不足');
            }

            //分店不能下單方包
            if($dept == 'D'){
//                return "權限不足";
                throw new AccessDeniedHttpException('權限不足');
            }
        }
        if ($user->can('workshop')) {
//            dump('workshop');
            $shopid = $request->shop;
        }
        if ($user->can('operation')) {
//            dump('operation');
            $shopid = $request->shop;
            if ($deli_date <= now()) {
//                return "權限不足";
                throw new AccessDeniedHttpException('權限不足');
            }
        }

        $items = WorkshopCartItem::getCartItems($shopid, $dept, $deli_date);
        $cats = WorkshopCat::getCatsNotExpired($deli_date , $dept);
//        dump($deliDate);
        $sampleItems = new Collection();
        if (count($items) == 0) {
            $sampleItems = WorkshopSample::getRegularOrderItems($shopid, $deliW ,$dept);
        }

        $this->productArr = WorkshopProduct::getProductCatIds();
        $this->special_dates = SpecialDate::where('special_date', $deli_date)->get();

//        dump($items);
        foreach ($items as $item) {
            $item->product_id = $item->itemID;
            $this->checkInvalidOrder($item,$deli_date,$shopid);
        }

//        dd($sampleItems);
        foreach ($sampleItems as $sampleItem) {
            $sampleItem->product_id = $sampleItem->itemID;
            $this->checkInvalidOrder($sampleItem,$deli_date,$shopid);
        }

//        dump($items->toArray());
//        dump($sampleItems->toArray());

        $deptArr= config('dept.symbol_and_name_all');

        $orderInfos = new Collection();
        $orderInfos->date = $deli_date;
        $orderInfos->shopid = $shopid;

        $orderInfos->shop_name = User::find($shopid)->txt_name;
        $orderInfos->dept = $dept;
        $orderInfos->dept_name = $deptArr[$dept];
        $orderInfos->deli_date = $deli_date;

        return view('order.cart', compact('items', 'cats', 'sampleItems', 'orderInfos'));
    }

    //ajax加載分組
    public function showGroup($catid ,$shopid)
    {
        $groups = WorkshopGroup::where('cat_id', $catid)->whereHas('products', function (Builder $query) use($shopid){
            $query->whereHas('prices', function (Builder $query) use($shopid){
                $shop_group_id = User::getShopGroupId($shopid);
                $query->where('shop_group_id', '=', $shop_group_id);
            });
        })->get();

        return view('order.cart_group', compact('groups'))->render();
    }

    //ajax加載產品
    public function showProduct($groupid, $shopid, Request $request)
    {
        $shop_group_id = User::getShopGroupId($shopid);
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
//        dd($products);
        $deli_date = $request->deli_date;

        $group = WorkshopGroup::find($groupid);
        $infos = new Collection();
        $infos->group_name = $group->group_name;
        $infos->cat_name = $group->cats->cat_name;

        $this->productArr = WorkshopProduct::getProductCatIds();
        $this->special_dates = SpecialDate::where('special_date', $deli_date)->get();
//        dump($this->productArr->toArray());

        foreach ($products as $product) {

            $productDetail = $product->prices->where('shop_group_id', '=', $shop_group_id)->first();

            $this->checkInvalidOrder($productDetail,$deli_date,$shopid);

            $this->resetProduct($product,$productDetail);

        }

        return view('order.cart_product', compact('products','infos'))->render();
    }

    //判斷是否能下單
    //$product必須有phase,cuttime,canordertime,product_id
    private function checkInvalidOrder($product,$deli_date,$shopid)
    {
        $product->order_by_workshop = false;
        $product->cut_order = false;
        $product->not_deli_time = false;

        $phase = $product->phase;
        $deliW = Carbon::parse($deli_date)->isoFormat('d');
        $canOrderTime = explode(",", $product->canordertime);

        //判斷是否後台落單
        if ($phase <= 0) {
            $product->order_by_workshop = true;
        }

        //跳過出貨期不出貨(星期日不是出貨期)
        if (($deliW - $phase) <= 0 && !in_array('0', $canOrderTime) && $phase > 0) {
            $phase += 1;
        }

        //判斷是否已截單
        if ($phase > 0) {
            $cuttime = $deli_date . " " . $product->cuttime . "00";
            $finalOrderTime = Carbon::parse($cuttime)->subDay($phase);
//            dump($finalOrderTime->toDateTimeString());
            $now = Carbon::now();
            $product->cut_order = $finalOrderTime->lt($now);
        }

        //判斷是否在出貨期
        //送貨日期不在可下單日期時
        if (!in_array($deliW, $canOrderTime)) {
            $product->not_deli_time = true;
        }

        $productArr = $this->productArr;
        $special_dates = $this->special_dates;
//        dump($special_dates);
        foreach ($special_dates as $special_date){
            $catArr = explode(',', $special_date->cat_ids);
            $shopArr = explode(',', $special_date->user_ids);
//            dump($catArr);
//            dump($shopArr);

            $cat_id = $productArr[$product->product_id] ?? 0 ;

            if (in_array($cat_id, $catArr) && in_array($shopid, $shopArr)){
                $product->not_deli_time = false;
                break;
            }
        }


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
