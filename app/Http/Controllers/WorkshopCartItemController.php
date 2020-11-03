<?php

namespace App\Http\Controllers;


use App\Models\WorkshopCartItem;
use App\Models\WorkshopCartItemLog;
use App\Models\WorkshopCat;
use App\Models\WorkshopGroup;
use App\Models\WorkshopProduct;
use App\Models\WorkshopSample;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WorkshopCartItemController extends Controller
{
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

            //新增
//            $insertArr = array();
            foreach ($insertDatas as $insertData) {
                //插入數據
                $insertArr = [
                    'order_date' => $now,
                    'user_id' => $shopid,
                    'product_id' => $insertData['itemid'],
                    'qty' => $insertData['qty'],
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
                    'input' => '新增數量'.$insertData['qty'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ];

                $cartItemLogsModel->insert($insertLogsArr);

            }


//            dump($updateLogsArr);

            //更新
            $updateLogsArr = array();
            foreach ($updateDatas as $updateData) {
                $cartItemModel::where('id', $updateData['mysqlid'])->update(['qty' => $updateData['qty']]);
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
                return "權限不足";
            }

            //分店不能下單方包
            if($dept == 'D'){
                return "權限不足";
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
                return "權限不足";
            }
        }

        $items = WorkshopCartItem::getCartItems($shopid, $dept, $deli_date);
        $cats = WorkshopCat::getCatsNotExpired($deli_date , $dept);
//        dump($deliDate);
        $sampleItems = new Collection();
        if (count($items) == 0) {
            $sampleItems = WorkshopSample::getRegularOrderItems($shopid, $deliW ,$dept);
        }

        foreach ($items as $item) {
            $this->checkInvalidOrder($item,$deli_date);
        }

        foreach ($sampleItems as $sampleItem) {
            $this->checkInvalidOrder($sampleItem,$deli_date);
        }

//        dump($items->toArray());
//        dump($sampleItems->toArray());

        $deptArr= ['A'=>'第一車','B'=>'第二車','C'=>'麵頭','D'=>'方包'];

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
    public function showGroup($catid)
    {
        $groups = WorkshopGroup::where('cat_id', $catid)->get();

        return view('order.cart_group', compact('groups'))->render();
    }

    //ajax加載產品
    public function showProduct($groupid, Request $request)
    {
        $products = WorkshopProduct::with('cats')
            ->with('units')
            ->where('group_id', $groupid)
            ->where('status', '!=', 4)
            ->get();
//        dump($products);
        $deli_date = $request->deli_date;

        $group = WorkshopGroup::find($groupid);
        $infos = new Collection();
        $infos->group_name = $group->group_name;
        $infos->cat_name = $group->cats->cat_name;
//        dump($infos);
        foreach ($products as $product) {
//            dump($deli_date.$product->cuttime);
            $this->checkInvalidOrder($product,$deli_date);
//            dump(mb_substr($product->cats->cat_name,0,4));

        }
//          dump($products->toArray());

        return view('order.cart_product', compact('products','infos'))->render();
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
}
