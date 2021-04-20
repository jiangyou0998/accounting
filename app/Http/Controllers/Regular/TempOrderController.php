<?php

namespace App\Http\Controllers\Regular;


use App\Http\Controllers\Controller;
use App\Models\WorkshopCartItem;
use App\Models\WorkshopProduct;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


//臨時加單
class TempOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request)
    {
        $shops = User::getKingBakeryShops();
        $info = WorkshopProduct::where('id', $request->product_id)->first();
        return view('order.regular.temp.create', compact('info', 'shops'));
    }

    public function store(Request $request){

        $shops = User::getKingBakeryShops();

        $shopids = $shops->pluck('id');

        $start_date = $request->start;
        $end_date = $request->end;
        $dept = 'F';

        $shop_group_id = 1;

        //2021-01-06 下單時候價格改為從prices表獲取
        $prices = WorkshopProduct::with('prices')->whereHas('prices', function (Builder $query) use($shop_group_id){
            $query->where('shop_group_id', '=', $shop_group_id);
        })->get()->mapWithKeys(function ($item) use($shop_group_id){
            $price = $item['prices']->where('shop_group_id', $shop_group_id)->first()->price;
            return [$item['id'] => $price ];
        });

        $insertDatas = json_decode($request->insertData, true);

        $insertArr = array();
        if($end_date >= $start_date){
            $start = Carbon::parse($start_date);
            $end = Carbon::parse($end_date);
            $time = $start;
            while($end->gte($time)) {
                foreach ($insertDatas as $insertData){
                    $deli_date = $time->toDateString();
                    $product_id = $request->input('productid');

                    $insertArr[] = [
                        'user_id' => $insertData['userid'],
                        'product_id' => $product_id,
                        'qty' => $insertData['qty'],
                        'order_price' => $prices[$product_id],
                        'dept' => $dept,
                        'ip' => $request->ip(),
                        'status' => 1,
                        'deli_date' => $deli_date,
                    ];

                }
                $time = $time->addDay();
            }
        }

        DB::transaction(function () use($insertArr, $dept){
            foreach ($insertArr as $value){
                $searchArr = [
                    'user_id' => $value['user_id'],
                    'product_id' => $value['product_id'],
                    'deli_date' => $value['deli_date'],
                    'dept' => $dept,
                ];
                WorkshopCartItem::where('status', '!=', 4)->updateOrCreate($searchArr, $value);
            }
        });

    }

}
