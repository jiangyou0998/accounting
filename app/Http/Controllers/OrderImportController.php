<?php

namespace App\Http\Controllers;


use App\Handlers\OrderImportHandler;
use App\Models\CustomerOrderCode;
use App\Models\WorkshopCartItem;
use App\Models\WorkshopCartItemLog;
use App\Models\WorkshopProduct;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

//外客柯打導入
class OrderImportController extends Controller
{

    public function index(Request $request)
    {
        $shop_group_id = $request->shop_group_id;

        if(is_null($shop_group_id)){
            throw new AccessDeniedHttpException('必須選擇要導入分組');
        }

        $shops = User::getShopsByShopGroup($shop_group_id);

        return view('order.order_import.index', compact('shops'));
    }

    //讀取Excel資料
    public function read_excel_result(Request $request, OrderImportHandler $uploader)
    {
        $shop_group_id = $request->shop_group_id;

        $result = $uploader->excel_to_array($request->file);

        $customer_order_codes = CustomerOrderCode::getCodes($shop_group_id)
            ->mapWithKeys(function ($item, $key) {
                return [$item['customer_order_code'] => $item];
            })
            ->toArray();

        $titles = array_column($result, 'Order Quantity', 'Material');

        $products  = WorkshopProduct::whereNotIn('status', [2, 4])
            ->has('prices')
            ->ofShopGroup($shop_group_id)
            ->get();

        $codeProductArr = $products->pluck('code_product', 'id')->toArray();

        return redirect()->route('order.order_import', ['shop_group_id' => $shop_group_id])->with([
            'result' => $result,
            'titles' => $titles,
            'shop_id' => $request->shop,
            'deli_date' => $request->deli_date,
            'codes' => $customer_order_codes,
            'codeProductArr' => $codeProductArr
        ]);
    }

    //匹配 內聯網產品Code 與 外客產品Code
    public function match_code(Request $request)
    {
        $shop_group_id = $request->shop_group_id;
        $product_id = $request->product_id;
//        $product_name = $request->product_name;
        $code = $request->code;

        $message = [];
        $message['status'] = 'success';

        //如該產品已存在,則不保存匹配結果
        if (CustomerOrderCode::query()
            ->where('shop_group_id', $shop_group_id)
            ->where('customer_order_code', $code)
            ->first()){
            $message['status'] = 'error';
            $message['error'] = '編號已存在,匹配失敗';
        }else{
            CustomerOrderCode::insert([
                'shop_group_id' => $shop_group_id,
                'product_id' => $product_id,
                'customer_order_code' => $code,
            ]);

//            $div = <<<HTML
//    <div class="col-md-12 mb-3 alert alert-success match-success" data-code="{{ $code }}" data-productid="{{ $product_id }}" data-qty="7">
//        {{ $code }} =&gt; {{ $product_name }} =&gt; 7
//    </div>
//HTML;
        }
        return json_encode($message, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function save_order(Request $request)
    {
        $user = Auth::User();
        $deli_date = $request->deli_date;
        $shop_id = $request->shop_id;

        //除workshop外,都不能下單
        if (!$user->can('workshop')) {
            throw new AccessDeniedHttpException('權限不足');
        }

        $orderCount = WorkshopCartItem::getExistDataByShopidAndDelidate($shop_id, $deli_date, 'CU')->count();

        $message = [];
        $message['status'] = 'success';

        if ($orderCount === 0){
            $this->insert_order($request, $user);
        }else{
            $message['status'] = 'error';
            $message['error'] = '選擇日期已下單，不能重複下單';
        }

        return json_encode($message, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

    }

    public function insert_order(Request $request ,$user)
    {
        // 数据库事务处理
        DB::transaction(function () use ($user, $request) {

            $insertDatas = json_decode($request->insertData, true);
            $deli_date = $request->deli_date;
            $shopid = $request->shop_id;
            $ip = $request->ip();
            $cartItemModel = new WorkshopCartItem();
            $cartItemLogsModel = new WorkshopCartItemLog();
            $now = Carbon::now()->toDateTimeString();

            $shop_group_id = User::getShopGroupId($shopid);

            //下單時候價格改為從prices表獲取
            $prices = WorkshopProduct::with('prices')->whereHas('prices', function (Builder $query) use($shop_group_id){
                $query->where('shop_group_id', '=', $shop_group_id);
            })->get()->mapWithKeys(function ($item) use($shop_group_id){
                $price = $item['prices']->where('shop_group_id', $shop_group_id)->first()->price;
                return [$item['id'] => $price ];
            });

            //新增
            foreach ($insertDatas as $insertData) {
                //插入數據
                $insertArr = [
                    'order_date' => $now,
                    'user_id' => $shopid,
                    'product_id' => $insertData['itemid'],
                    'qty' => $insertData['qty'],
                    'order_price' => $prices[$insertData['itemid']],
                    'ip' => $ip,
                    'status' => 1,
                    'dept' => 'CU',
                    'insert_date' => $now,
                    'deli_date' => $deli_date
                ];
                $cartItemId = $cartItemModel->insertGetId($insertArr);

                //寫入LOG
                $insertLogsArr= [
                    'operate_user_id' => $user->id,
                    'shop_id' => $shopid,
                    'product_id' => $insertData['itemid'],
                    'cart_item_id' => $cartItemId,
                    'method' => 'IMPORT_INSERT',
                    'ip' => $ip,
                    'input' => 'Excel導入,新增數量'.$insertData['qty'].',價格:'.$prices[$insertData['itemid']],
                    'created_at' => $now,
                    'updated_at' => $now,
                ];

                $cartItemLogsModel->insert($insertLogsArr);

            }

        });
    }

}
