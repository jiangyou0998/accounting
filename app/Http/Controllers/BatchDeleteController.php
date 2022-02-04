<?php

namespace App\Http\Controllers;


use App\Models\ShopGroup;
use App\Models\ShopGroupHasUser;
use App\Models\WorkshopCartItem;
use App\Models\WorkshopCartItemLog;
use App\Models\WorkshopProduct;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BatchDeleteController extends Controller
{
    public function index()
    {
        $shop_group_ids = ShopGroup::all()->sortBy('sort')->pluck('name','id');

        $products = WorkshopProduct::whereNotIn('status', [2, 4])
            ->has('prices')
            ->get();
//        $productArr = $products->pluck('product_name', 'id')->toArray();
        $codeProductArr = $products->pluck('code_product', 'id')->toArray();

//        dd($shop_group_ids);
        return view('order.batch_delete.index', compact('shop_group_ids', 'codeProductArr'));
    }

    public function delete(Request $request)
    {
        $user = Auth::User();

        $shop_group_id = $request->shop_group_id;
        $product_id = $request->product_id;
        $start = $request->start;
        $end = $request->end;

//        dump($prices);

        $shop_ids = ShopGroupHasUser::where('shop_group_id', $shop_group_id)->get()->pluck('user_id');
//        dd($shopgroups->pluck('user_id'));

        $cart_items = WorkshopCartItem::query()
            ->whereBetween('deli_date', [ $start, $end ])
            ->whereIn('user_id', $shop_ids)
            ->where('product_id', $product_id)
            ->notDeleted()
            ->get();

        // 数据库事务处理
        DB::transaction(function () use ($user, $cart_items, $request) {

            $ip = $request->ip();
            $cartItemLogsModel = new WorkshopCartItemLog();
            $now = Carbon::now()->toDateTimeString();

            foreach ($cart_items as $cart_item){
                //修改狀態為刪除
                $cart_item->status = 4;
                $cart_item->save();

                $workshopDeleteLogsArr[] = [
                    'operate_user_id' => $user->id,
                    'shop_id' => $cart_item->user_id,
                    'product_id' => $cart_item->product_id,
                    'cart_item_id' => $cart_item->id,
                    'method' => 'WORKSHOP_DELETE',
                    'ip' => $ip,
                    'input' => '工場批量刪除',
                    'created_at' => $now,
                    'updated_at' => $now,
                ];

            }

            //寫入LOG
            $cartItemLogsModel->insert($workshopDeleteLogsArr);

        });

//        dump($cart_items->count());
        return 'success';
    }

    //
    public function check(Request $request)
    {
        $shop_group_id = $request->shop_group_id;
        $product_id = $request->product_id;
        $start = $request->start;
        $end = $request->end;


        $shop_ids = ShopGroupHasUser::query()->where('shop_group_id', $shop_group_id)->get()->pluck('user_id');
//        dd($shopgroups->pluck('user_id'));

        $cart_items = WorkshopCartItem::query()
            ->whereBetween('deli_date', [ $start, $end ])
            ->whereIn('user_id', $shop_ids)
            ->where('product_id', $product_id)
            ->notDeleted()
            ->get();

        $count = count($cart_items);

        $shops = User::query()->whereIn('id', $shop_ids)->pluck('txt_name', 'id');
        $products = WorkshopProduct::all()->pluck('product_name', 'id');

        $search_items = [];
        foreach ($cart_items as $cart_item){
            $search_item = [
                'shop_name' => $shops[$cart_item->user_id] ?? '',
                'product_name' => $products[$cart_item->product_id] ?? '',
                'deli_date' => $cart_item->deli_date,
                'qty' => $cart_item->qty,
            ];
            $search_items[] = $search_item;
        }

        $data = [
            'status'                =>  'success',
            'count'                 =>  $count,
            'msg'                   =>  '',
            'search_items'          =>  $search_items,
        ];

        return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

    }


}
