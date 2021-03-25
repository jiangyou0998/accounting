<?php

namespace App\Http\Controllers\KB;


use App\Http\Controllers\Controller;
use App\Models\KB\KBUser;
use App\Models\KB\KBWorkshopCartItem;
use App\Models\KB\KBWorkshopCartItemLog;
use App\Models\KB\KBWorkshopCat;
use App\Models\KB\KBWorkshopGroup;
use App\Models\KB\KBWorkshopOrderSample;
use App\Models\KB\KBWorkshopProduct;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class KBWorkshopCartItemController extends Controller
{
    public function update(Request $request, $shopid)
    {
        $user = Auth::User();

        if ($user->can('shop')) {
//            dump('shop');
            $shopid = KBUser::where('rb_user_id',$user->id)->first()->id;
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
            $cartItemModel = new KBWorkshopCartItem();
            $cartItemLogsModel = new KBWorkshopCartItemLog();
            $now = Carbon::now()->toDateTimeString();

//            dump($insertDatas);
//            dump($delDatas);

            //2020-11-23 新增下單時候的價格
//            $prices = KBWorkshopProduct::all()->pluck('default_price','id');

            $prices = KBWorkshopProduct::with('prices')->whereHas('prices', function (Builder $query) {
                $query->where('shop_group_id', '=', 5);
            })->get()->mapWithKeys(function ($item) {
                $price = $item['prices']->where('shop_group_id', 5)->first()->price;
                return [$item['id'] => $price ];
            });

//            dd($prices->toArray());

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
            $shopid = KBUser::where('rb_user_id',$user->id)->first()->id;
            //分店無法修改明日之前的訂單
            if ($deli_date <= now()) {
//                return "權限不足";
                throw new AccessDeniedHttpException('權限不足');
            }

        }
        if ($user->can('workshop')) {
//            dump('workshop');
            $shopid = KBUser::where('rb_user_id',$request->shop)->first()->id;
        }
        if ($user->can('operation')) {
//            dump('operation');
            $shopid = KBUser::where('rb_user_id',$request->shop)->first()->id;
            if ($deli_date <= now()) {
//                return "權限不足";
                throw new AccessDeniedHttpException('權限不足');
            }
        }

        $items = KBWorkshopCartItem::getCartItems($shopid, $dept, $deli_date);
        $cats = KBWorkshopCat::getCatsNotExpired($deli_date , $dept);
//        dump($deliDate);
        $sampleItems = new Collection();
        if (count($items) == 0) {
            $sampleItems = KBWorkshopOrderSample::getRegularOrderItems($shopid, $deliW ,$dept);
        }

        foreach ($items as $item) {
            $this->checkInvalidOrder($item,$deli_date);
        }

        foreach ($sampleItems as $sampleItem) {
            $this->checkInvalidOrder($sampleItem,$deli_date);
        }

//        dump($items->toArray());
//        dump($sampleItems->toArray());

        //糧友在蛋撻王工場下單標識為RB
        $deptArr= ['RB'=>'蛋撻王工場'];

        $orderInfos = new Collection();
        $orderInfos->date = $deli_date;
        $orderInfos->shopid = $shopid;

        $orderInfos->shop_name = KBUser::find($shopid)->txt_name;
        $orderInfos->dept = $dept;
        $orderInfos->dept_name = $deptArr[$dept];
        $orderInfos->deli_date = $deli_date;

        return view('kb.order.cart', compact('items', 'cats', 'sampleItems', 'orderInfos'));
//        return view('kb.order.cart', compact('items', 'cats', 'orderInfos'));
    }

    //ajax加載分組
    public function showGroup($catid)
    {
        $groups = KBWorkshopGroup::where('cat_id', $catid)->whereHas('products', function (Builder $query) {
            $query->whereHas('prices', function (Builder $query) {
                $query->where('shop_group_id', '=', 5);
            });
        })->get();

        return view('kb.order.cart_group', compact('groups'))->render();
    }

    //ajax加載產品
    public function showProduct($groupid, Request $request)
    {
        $products = KBWorkshopProduct::with('cats')
            ->with('units')
            ->where('group_id', $groupid)
            //2021-02-25 不顯示暫停產品
            ->whereNotIn('status', [2, 4])
            ->whereHas('prices', function (Builder $query) {
                $query->where('shop_group_id', '=', 5);
            })
            //2020-02-25 產品排序
            ->orderBy('product_no')
            ->get();
//        dump($products);
        $deli_date = $request->deli_date;

        $group = KBWorkshopGroup::find($groupid);
        $infos = new Collection();
        $infos->group_name = $group->group_name;
        $infos->cat_name = $group->cats->cat_name;
//        dump($infos);
        foreach ($products as $product) {
//            dump($deli_date.$product->cuttime);
            $productDetail = $product->prices->where('shop_group_id', 5)->first();

            $this->checkInvalidOrder($productDetail,$deli_date);

            $this->resetProduct($product,$productDetail);

//            dump(mb_substr($product->cats->cat_name,0,4));

        }
//          dump($products->toArray());

        return view('kb.order.cart_product', compact('products','infos'))->render();
    }

    //判斷是否能下單
    //$product必須有phase,cuttime,canordertime
    private function checkInvalidOrder($product,$deli_date)
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
        //2021-03-22 全跳過星期日
        //2021-03-25 星期日時不用跳
        if (($deliW - $phase) <= 0 && $deliW != 0 && $phase > 0) {
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
