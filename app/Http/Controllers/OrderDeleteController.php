<?php

namespace App\Http\Controllers;


use App\Models\ShopGroup;
use App\Models\WorkshopCartItem;
use App\Models\WorkshopCartItemLog;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class OrderDeleteController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $shop_group_ids = ShopGroup::all()->sortBy('sort')->pluck('name','id');
        $checkHtml = '';
        foreach ($shop_group_ids as $shop_group_id => $shop_name){
            $checkHtml .= $this->getCheckboxHtml($shop_group_id, $shop_name);
        }
        return view('order.order_delete.index',compact('checkHtml'));
    }

    //柯打刪除(按選中分店刪除)
    public function delete(Request $request)
    {
        return DB::transaction(function () use($request){

            $user = Auth::User();
            $ip = $request->ip();
            $now = Carbon::now()->toDateTimeString();

            $shops = $request->shops;
            $shopsArr = explode(',', $shops);
            //修改後日期
            $target_date = $request->target_date;
            //修改原因
            $reason = $request->reason;

            $cartItemModel = new WorkshopCartItem();

            //目標日期柯打刪除
            $delete_items = WorkshopCartItem::where('status', '!=' , 4)
                ->whereIn('user_id', $shopsArr)
                ->where('deli_date', $target_date)
                ->get();

            $deleteArr = array();
            $deleteLogsArr = array();

            foreach ($delete_items as $item){
                $item->status = 4;
                $deleteArr[] = [
                    'id' => $item->id,
                    'status' => 4,
                    //phase標記為1, 用於回滾操作
                    'chr_phase' => 1,
                ];

                //刪除Log
                $deleteLogsArr[] = [
                    'operate_user_id' => $user->id,
                    'shop_id' => $item->user_id,
                    'product_id' => $item->product_id,
                    'cart_item_id' => $item->id,
                    'method' => 'ORDER_ONLY_DELETE',
                    'ip' => $ip,
                    'input' => '因'.$reason.'原因,當日訂單刪除',
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            $data = [
                'status' => 'success',
                'msg'   => '柯打刪除成功!'
            ];

            if(count($delete_items) < 5){
                $data['status'] = 'error';
                $data['msg'] = '所選數據數量少於5,刪除失敗!';
                return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

            }

            //先將目標日期數據刪除(status變為4)
            $cartItemModel->updateBatch($deleteArr);

            $cartItemLogsModel = new WorkshopCartItemLog();
            $cartItemLogsModel->insert($deleteLogsArr);

            return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        });

    }

    //柯打恢復(按選中分店恢復)
    public function rollback(Request $request)
    {
        return DB::transaction(function () use($request){

            $user = Auth::User();
            $ip = $request->ip();
            $now = Carbon::now()->toDateTimeString();

            $shops = $request->shops;
            $shopsArr = explode(',', $shops);
            //修改後日期
            $target_date = $request->target_date;
            //修改原因
            $reason = $request->reason;

            $cartItemModel = new WorkshopCartItem();

            $target_date_items = WorkshopCartItem::where('status', '!=' , 4)
                ->whereIn('user_id', $shopsArr)
                ->where('deli_date', $target_date)
                ->get();

            //所選日子必須未下單才可以恢復
            if(count($target_date_items) > 0){
                $data['status'] = 'error';
                $data['msg'] = '所選日子已下單，無法進行恢復操作！';
                return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            }

            //目標日期柯打恢復
            $rollback_items = WorkshopCartItem::where('status', '=' , 4)
                ->where('chr_phase', 1)
                ->whereIn('user_id', $shopsArr)
                ->where('deli_date', $target_date)
                ->get();

            if(count($rollback_items) === 0){
                $data['status'] = 'error';
                $data['msg'] = '沒有可用於恢復的數據！';
                return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            }

            $rollbackArr = array();
            $rollbackLogsArr = array();

            foreach ($rollback_items as $item){
                $item->status = 1;
                $rollbackArr[] = [
                    'id' => $item->id,
                    'status' => 1,
                    //phase標記為0, 不在能用於回滾恢復
                    'chr_phase' => 0,
                ];

                //恢復Log
                $rollbackLogsArr[] = [
                    'operate_user_id' => $user->id,
                    'shop_id' => $item->user_id,
                    'product_id' => $item->product_id,
                    'cart_item_id' => $item->id,
                    'method' => 'ORDER_ROLLBACK',
                    'ip' => $ip,
                    'input' => '因'.$reason.'原因,當日訂單恢復',
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            $data = [
                'status' => 'success',
                'msg'   => '柯打恢復成功!'
            ];

            //先將目標日期數據恢復(status變為1)
            $cartItemModel->updateBatch($rollbackArr);

            $cartItemLogsModel = new WorkshopCartItemLog();
            $cartItemLogsModel->insert($rollbackLogsArr);

            return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        });

    }

    //選擇分店checkbox
    private function getCheckboxHtml($shop_group_id, $shop_name)
    {
        $shops = User::getShopsByShopGroup($shop_group_id);
//        dd($shops->toArray());

        $linecount = 1;
        $checkHtml = <<<HTML
    <br>
    <span style="color: #FF0000; font-size: 172%; ">{$shop_name}</span>
    <span style="color: #FF0000; font-size: 172%; ">&#12288;全選</span>
    <input class="check-all" type="checkbox" data-group="{$shop_group_id}"  onclick="checkAll(this)">
    <br>
HTML;

        //分店多選框
        foreach ($shops as $shop) {

            $check = <<<HTML
    <label style="padding-right:15px;">
    <input type="checkbox" class="shop" data-group="{$shop_group_id}" value="{$shop->id}" /><span class="checkbox">{$shop->report_name}</span>
    </label>
HTML;
//            $check .= '<input type="checkbox" class="shop" data-group="{$shop_group_id}" value="' . $shop->id . '" /><span class="checkbox">' . $shop->report_name.'</span>';
//            $check .= '</label>';

            $linecount++;
            if ($linecount >= 10) {
                $check .= '<br>';
                $linecount = 1;
            }

            $checkHtml .= $check;

        }

        $checkHtml .= '<br>';

        return $checkHtml;
    }


}
