<?php

namespace App\Http\Controllers;

use App\Models\WorkshopCartItem;
use App\Models\WorkshopCartItemLog;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class DeliController extends Controller
{

    public function list(Request $request)
    {
        $now = Carbon::now();
        //如果URL沒有送貨日期,使用當日日期
        if(isset($request->deli_date)){
            $deli_date = $request->deli_date;
        }else{
            $deli_date = $now->toDateString();
        }

//        $deli_date = '2020-10-09';
        $lists = WorkshopCartItem::getDeliLists($deli_date);

//        dump($lists->toArray());

        $infos = new Collection();
        $infos->deli_date = $deli_date;

        return view('order.deli.edit.list',compact('lists','infos'));
    }

    protected function deli_edit(Request $request)
    {
        $now = Carbon::now();
        $user = Auth::user();
        //如果URL沒有送貨日期,使用當日日期
        if(isset($request->deli_date)){
            $deli_date = $request->deli_date;
        }else{
            $deli_date = $now->toDateString();
        }

        if ($user->can('shop')) {
//            dump('shop');
            $shop = $user->id;
            //分店無法修改明日之前的訂單
            if ($deli_date != $now->toDateString()) {
//                return "權限不足";
                throw new AccessDeniedHttpException('訂單只能當天收貨');
            }

        }else if ($user->can('operation')) {
            $shop = $request->shop;
        }else{
            //2021-02-02 非shop operation無權修改
            throw new AccessDeniedHttpException('權限不足');
        }

        //送貨單詳細數據
        $items = WorkshopCartItem::getDeliItem($deli_date,$shop);

        $dept_price = array();
        foreach(array("A", "B", "C" , "D") as $dept){
            $dept_price[$dept] = 0;
        }

        $po = array();
        $total_price = 0;
//        dump($items);

        //處理查詢數據用於頁面顯示
        foreach ($items as $item){
//    var_dump($po);
//            $po[$item->product_id]['totalqty'] = 0;
//            $po[$item->product_id]['totalreceivedqty'] = 0;

            $po[$item->product_id]['unit'] = $item->UoM;
            $po[$item->product_id]['name'] = $item->item_name;
            $po[$item->product_id]['price'] = $item->default_price;
            if(isset($po[$item->product_id]['totalqty'])){
                $po[$item->product_id]['totalqty'] += $item->dept_qty;
            }else{
                $po[$item->product_id]['totalqty'] = $item->dept_qty;
            }

            if(isset($po[$item->product_id]['totalreceivedqty'])){
                $po[$item->product_id]['totalreceivedqty'] += $item->qty_received;
            }else{
                $po[$item->product_id]['totalreceivedqty'] = $item->qty_received;
            }

            $po[$item->product_id]['reason'] = $item->reason;
            $po[$item->product_id]['qty'][$item->dept]["qty"] = $item->qty_received;
            $po[$item->product_id]['qty'][$item->dept]["deptqty"] = $item->dept_qty;
            $po[$item->product_id]['qty'][$item->dept]["mysqlid"] = $item->orderID;

            //部門總價
            $dept_price[$item->dept] += ($item->default_price * $item->qty_received);
            //總價
            $total_price += ($item->default_price * $item->qty_received);
        }

        //原因
        $reasonArr = [
            0=>'請選擇原因',
            1=>'品質問題 (壞貨)',
            2=>'執漏貨',
            3=>'執錯貨',
//            4=>'分店落錯貨，即日收走',
            5=>'打錯單',
//            6=>'抄碼',
            7=>'運送途中損爛',
            8=>'運輸送錯分店',
            9=>'缺貨',
            10=>'廠派貨',
//            11=>'分店要求扣數',
//            12=>'分店要求加單',
            13=>'不明原因'
        ];

        $infos = new Collection();
        $infos->deli_date = $deli_date;
        $infos->shop = User::find($shop)->txt_name;

        return view('order.deli.edit.edit',compact('po' ,'infos', 'reasonArr' , 'dept_price' , 'total_price'));
    }

    public function deli_update(Request $request)
    {
        $user = Auth::User();
//        dd($user);

        // 数据库事务处理
        DB::transaction(function () use ($user, $request) {


            $updateDatas = json_decode($request->updateData, true);

            $ip = $request->ip();
            $shopid = $request->shopid;
            $cartItemModel = new WorkshopCartItem();
            $cartItemLogsModel = new WorkshopCartItemLog();
            $now = Carbon::now()->toDateTimeString();

//            dump($updateDatas);
//            dump($updateDatas);
//            dump($delDatas);

            //更新
            $updateLogsArr = array();
            foreach ($updateDatas as $updateData) {
                $cartItemModel::where('id', $updateData['mysqlid'])
                    ->update([
                        'qty_received' => $updateData['receivedqty'],
                        'received_date'=> $now,
                        'reason' => $updateData['reason'],
                    ]);
//                $productModel = new WorkshopProduct();
                $updateLogsArr[] = [
                    'operate_user_id' => $user->id,
                    'shop_id' => $shopid,
                    'product_id' => $cartItemModel::find($updateData['mysqlid'])->product_id,
                    'cart_item_id' => $updateData['mysqlid'],
                    'method' => 'MODIFY',
                    'ip' => $ip,
                    'input' => '後台修改數量，從' . $updateData['oldqty'] . '變為' . $updateData['receivedqty'].'，原因：'.$updateData['reason'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            //插入更新LOG
            $cartItemLogsModel->insert($updateLogsArr);


        });

    }

}
