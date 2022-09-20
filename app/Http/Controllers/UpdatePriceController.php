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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdatePriceController extends Controller
{
    public function index()
    {
        $shop_group_ids = ShopGroup::all()->sortBy('sort')->pluck('name','id');
        $products = WorkshopProduct::whereNotIn('status', [2, 4])
            ->has('prices')
            ->get();

        //2022-09-20 新增產品選擇
        $codeProductArr = $products->pluck('code_product', 'id')->toArray();
//        dd($codeProductArr);
        return view('order.update_price.index', compact('shop_group_ids', 'codeProductArr'));
    }

    public function modify(Request $request)
    {
        $user = Auth::User();

        $shop_group_id = $request->shop_group_id;
        $start = $request->start;
        $end = $request->end;
        $products = $request->products;

        //價格從prices表獲取
        $prices = WorkshopProduct::with('prices')->whereHas('prices', function (Builder $query) use($shop_group_id){
            $query->where('shop_group_id', '=', $shop_group_id);
        })->get()->mapWithKeys(function ($item) use($shop_group_id){
            $price = $item['prices']->where('shop_group_id', $shop_group_id)->first()->price;
            return [$item['id'] => $price ];
        });

//        dump($prices);

        $shop_ids = ShopGroupHasUser::where('shop_group_id', $shop_group_id)->get()->pluck('user_id');
//        dd($shopgroups->pluck('user_id'));

        $cart_items = WorkshopCartItem::whereBetween('deli_date', [ $start, $end])
            ->whereIn('user_id', $shop_ids)
            ->ofProduct($products)
            ->notDeleted()
            ->get();

        // 数据库事务处理
        DB::transaction(function () use ($user, $cart_items, $prices, $request) {

            $ip = $request->ip();
            $cartItemLogsModel = new WorkshopCartItemLog();
            $now = Carbon::now()->toDateTimeString();
            $count = 0;

            foreach ($cart_items as $cart_item){
                //下單時價格
                $old_price = $cart_item->order_price;
                //現時價格
                $new_price = $prices[$cart_item->product_id];
                if ($old_price !== $new_price){
                    $cart_item->order_price = $new_price;
                    $cart_item->save();

                    $updatePriceLogsArr[] = [
                        'operate_user_id' => $user->id,
                        'shop_id' => $cart_item->user_id,
                        'product_id' => $cart_item->product_id,
                        'cart_item_id' => $cart_item->id,
                        'method' => 'UPDATE_PRICE',
                        'ip' => $ip,
                        'input' => '更新價格（舊價：'.$old_price.'，新價:'.$new_price.'）',
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];

//                dump($old_price);
//                dump($new_price);
                    $count ++ ;
                }
            }

            //寫入LOG
            $cartItemLogsModel->insert($updatePriceLogsArr);

//            dump($count);

        });

//        dump($cart_items->count());
        return 'success';
    }

    //
    public function check(Request $request)
    {
        $shop_group_id = $request->shop_group_id;
        $start = $request->start;
        $end = $request->end;
        $products = $request->products;

        //價格從prices表獲取
        $prices = WorkshopProduct::query()->with('prices')->whereHas('prices', function (Builder $query) use($shop_group_id){
            $query->where('shop_group_id', '=', $shop_group_id);
        })->get()->mapWithKeys(function ($item) use($shop_group_id){
            $price = $item['prices']->where('shop_group_id', $shop_group_id)->first()->price;
            return [$item['id'] => $price ];
        });

//        dump($prices);

        $shop_ids = ShopGroupHasUser::query()->where('shop_group_id', $shop_group_id)->get()->pluck('user_id');
//        dd($shopgroups->pluck('user_id'));

        $cart_items = WorkshopCartItem::query()
            ->whereBetween('deli_date', [ $start, $end ])
            ->whereIn('user_id', $shop_ids)
            ->ofProduct($products)
            ->notDeleted()
            ->get();

        $count = 0;

        $shops = User::query()->whereIn('id', $shop_ids)->pluck('txt_name', 'id');
        $products = WorkshopProduct::all()->pluck('product_name', 'id');

        $different_items = [];
        foreach ($cart_items as $cart_item){
            //下單時價格
            $old_price = $cart_item->order_price;
            //現時價格
            $new_price = $prices[$cart_item->product_id];
            if ($old_price !== $new_price){
                $cart_item->order_price = $new_price;
                $different_item = [
                    'shop_name' => $shops[$cart_item->user_id] ?? '',
                    'product_name' => $products[$cart_item->product_id] ?? '',
                    'old_price' => $old_price,
                    'new_price' => $new_price,
                    'deli_date' => $cart_item->deli_date,
                ];
                $different_items[] = $different_item;
                $count ++ ;
            }
        }

        $data = [
            'status'                =>  'success',
            'count'                 =>  $count,
            'msg'                   =>  '價格更新成功!',
            'different_item'        =>  $different_items,
        ];

        return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

    }


}
