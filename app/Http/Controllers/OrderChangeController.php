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


class OrderChangeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
//        $shops = User::getShopsByShopGroup(1);
        $shop_group_ids = ShopGroup::all()->pluck('name','id');
        $checkHtml = '';
        foreach ($shop_group_ids as $shop_group_id => $shop_name){
            $checkHtml .= $this->getCheckboxHtml($shop_group_id, $shop_name);
        }
        return view('order.order_change.index',compact('checkHtml'));
    }

    public function order_modify(Request $request)
    {

        DB::transaction(function () use($request){

            $user = Auth::User();
            $ip = $request->ip();
            $now = Carbon::now()->toDateTimeString();

            $shops = $request->shops;
            $shopsArr = explode(',', $shops);
            $original_date = $request->original_date;
            $target_date = $request->target_date;
            $reason = $request->reason;

//            dump($shops);
//            dump($original_date);
//            dump($target_date);
//            dd($reason);

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
                ];

                //刪除Log
                $deleteLogsArr[] = [
                    'operate_user_id' => $user->id,
                    'shop_id' => $item->user_id,
                    'product_id' => $item->product_id,
                    'cart_item_id' => $item->id,
                    'method' => 'OM_DELETE',
                    'ip' => $ip,
                    'input' => '因'.$reason.'原因,當日訂單刪除',
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            //柯打改期item
            $modify_items = WorkshopCartItem::where('status', '!=' , 4)
                ->whereIn('user_id', $shopsArr)
                ->where('deli_date', $original_date)
                ->get();

            $modifyArr = array();
            $modifyLogsArr = array();

            foreach ($modify_items as $item){
                $item->deli_date = $target_date;
                $modifyArr[] = [
                    'id' => $item->id,
                    'deli_date' => $target_date,
                ];

                //柯打改期Log
                $modifyLogsArr[] = [
                    'operate_user_id' => $user->id,
                    'shop_id' => $item->user_id,
                    'product_id' => $item->product_id,
                    'cart_item_id' => $item->id,
                    'method' => 'OM_CHANGE',
                    'ip' => $ip,
                    'input' => '因'.$reason.'原因,該單由'.$original_date.'改到'.$target_date,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            $cartItemModel->updateBatch($deleteArr);
            $cartItemModel->updateBatch($modifyArr);

            $cartItemLogsModel = new WorkshopCartItemLog();
            $cartItemLogsModel->insert($deleteLogsArr);
            $cartItemLogsModel->insert($modifyLogsArr);

        });

//        dump($shopsArr);
//        dd($items->toArray());
    }

    //選擇日期checkbox
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


        //星期日到星期六多選框
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
