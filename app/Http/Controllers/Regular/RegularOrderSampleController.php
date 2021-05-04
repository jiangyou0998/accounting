<?php

namespace App\Http\Controllers\Regular;


use App\Http\Controllers\Controller;
use App\Models\Regular\RegularOrder;
use App\Models\Regular\RegularOrderItem;
use App\Models\ShopGroup;
use App\Models\WorkshopProduct;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//批量下單範本
class RegularOrderSampleController extends Controller
{

    public function index(Request $request)
    {
        $shop_group_id = $request->input('shop_group_id') ?? 1;
        $sampleModel = new RegularOrder();
        $samples = $sampleModel
            ->select('id', 'orderdates','product_id')
            //2021-05-04 新增shop_group_id
            ->where('shop_group_id',$shop_group_id)
            ->where('disabled', 0)
            ->get();

        foreach ($samples as $sample) {
            $sample->orderdates = $this->transOrderDate($sample->orderdates);
        }

        $samples = $samples->groupBy('product_id');

        $products = WorkshopProduct::whereNotIn('status', [2, 4])
            ->whereHas('prices', function ($query) use($shop_group_id){
                $query->where('shop_group_id', '=', $shop_group_id);
            })
            ->get();
        $productArr = $products->pluck('product_name', 'id')->toArray();
        $codeProductArr = $products->pluck('code_product', 'id')->toArray();

        $shop_group_name = ShopGroup::find($shop_group_id)->name ?? "未選擇分組";

//        dump($samples->toArray());
//        dump($shop_group_name);
        return view('order.regular.sample.index', compact('samples','productArr' , 'codeProductArr' , 'shop_group_name' , 'shop_group_id'));
    }

    public function create(RegularOrder $sample ,Request $request)
    {
//        dump($sample);
        $sampleModel = new RegularOrder();
        $shop_group_id = $request->input('shop_group_id') ?? 1;

        $sampledate = $sampleModel
            ->select(DB::raw('group_concat(orderdates) as sampledate'))
            ->where('product_id' ,'=' , $request->product_id)
            ->where('shop_group_id',$shop_group_id)
            ->where('disabled', 0)
            ->first()->sampledate;

//        dump($sampledate);
//        dd($currentdate);
        $shops = User::getShopsByShopGroup($shop_group_id);

//        dump($shops);
        $info = WorkshopProduct::where('id', $request->product_id)->first();
//        dump($info);

        //regular_order_items表數據轉化成數組
        $itemsArr = RegularOrderItem::where('r_order_id',$sample->id)->get()->groupBy('user_id')->toArray();

//        dump($itemsArr);

        //選擇日期checkbox
        $checkHtml = $this->getCheckboxHtml($sampledate);

        return view('order.regular.sample.create_and_edit', compact('sample', 'shops', 'info' , 'itemsArr', 'checkHtml' , 'shop_group_id'));
    }

    public function edit(RegularOrder $sample)
    {
//        dump($sample);
        $sampleModel = new RegularOrder();
        $shop_group_id = $sample->shop_group_id;

        $sampledate = $sampleModel
            ->select(DB::raw('group_concat(orderdates) as sampledate'))
            ->where('id' ,'<>' , $sample->id)
            ->where('product_id' ,'=' , $sample->product_id)
            ->where('shop_group_id', $shop_group_id)
            ->where('disabled', 0)
            ->first()->sampledate;

        $currentdate = $sampleModel
            ->select(DB::raw('group_concat(orderdates) as sampledate'))
            ->where('id' ,'=' , $sample->id)
            ->where('product_id' ,'=' , $sample->product_id)
            ->where('shop_group_id', $shop_group_id)
            ->where('disabled', 0)
            ->first()->sampledate;

//        dump($sampledate);
//        dd($currentdate);
        $shops = User::getShopsByShopGroup($shop_group_id);

//        dump($shops);
        $info = WorkshopProduct::where('id', $sample->product_id)->first();
//        dump($info);

        //regular_order_items表數據轉化成數組
        $itemsArr = RegularOrderItem::where('r_order_id',$sample->id)->get()->groupBy('user_id')->toArray();

//        dump($itemsArr);

        //選擇日期checkbox
        $checkHtml = $this->getCheckboxHtml($sampledate , $currentdate);

        return view('order.regular.sample.create_and_edit', compact('sample', 'shops', 'info' , 'itemsArr', 'currentdate', 'checkHtml' , 'shop_group_id'));
    }

    public function store(Request $request)
    {

        DB::transaction(function () use($request){
            $insertDatas = json_decode($request->insertData, true);

//            dump($request->toArray());
//            dd($insertDatas);
            $sampleModel = new RegularOrder();
            $sampleId = $sampleModel::insertGetId([
                'product_id' => $request->productid,
                'shop_group_id' => $request->shop_group_id,
                'orderdates' => $request->orderdates,
                'disabled' => 0
            ]);

            $sampleItemArr = array();
            foreach ($insertDatas as $insertData){
                $sampleItemArr[] = [
                    'r_order_id' => $sampleId,
                    'user_id' => $insertData['userid'],
                    'qty' => $insertData['qty'],
                    'disabled' => 0
                ];
            }

            $sampleItemModel = new RegularOrderItem();
            $sampleItemModel::insert($sampleItemArr);
        });

    }

    public function update(Request $request, $sampleid)
    {
        DB::transaction(function () use($request ,$sampleid){

            $insertDatas = json_decode($request->insertData, true);

//            dump($request->toArray());
//            dd($insertDatas);
            $sampleModel = new RegularOrder();
            $sampleItemModel = new RegularOrderItem();
            $sampleModel::where('id', $sampleid)->update(['orderdates' => $request->orderdates]);
            $sampleItemModel::where('r_order_id', $sampleid)->delete();

            //插入
            $sampleItemArr = array();
            foreach ($insertDatas as $insertData){
                $sampleItemArr[] = [
                    'r_order_id' => $sampleid,
                    'user_id' => $insertData['userid'],
                    'qty' => $insertData['qty'],
                    'disabled' => 0
                ];
            }

            $sampleItemModel::insert($sampleItemArr);

        });
    }

    public function destroy($sampleid)
    {
        $sampleModel = new RegularOrder();
        $sampleModel::where('id',$sampleid)->update(['disabled' => 1]);
    }

    private function transOrderDate($orderdates)
    {
        $weekArr = [
            '0' => '星期日',
            '1' => '星期一',
            '2' => '星期二',
            '3' => '星期三',
            '4' => '星期四',
            '5' => '星期五',
            '6' => '星期六',
        ];

        foreach ($weekArr as $key => $value) {
            //將數字轉換為星期
            $orderdates = str_replace($key, $value, $orderdates);
        }

        return $orderdates;
    }

    //選擇日期checkbox
    private function getCheckboxHtml($sampledate ,$currentdate = null)
    {
        $sampledateArr = array();
        if ($sampledate != null){
            $sampledateArr =  explode(',', $sampledate);
        }

        $currentdateArr = array();
        if ($currentdate != null){
            $currentdateArr =  explode(',', $currentdate);
        }

        $weekArr = [
            '0' => '星期日',
            '1' => '星期一',
            '2' => '星期二',
            '3' => '星期三',
            '4' => '星期四',
            '5' => '星期五',
            '6' => '星期六',
        ];

        $linecount = 1;
        $checkHtml = '';
        //星期日到星期六多選框
        foreach ($weekArr as $key => $value) {

            if(in_array($key,$sampledateArr)){
                continue;
            }

            if(in_array($key,$currentdateArr)){
                $check = '<label style="padding-right:15px;">';
                $check .= '<input type="checkbox" name="week" value="' . $key . '" checked /><span class="checkbox">' . $value.'</span>';
                $check .= '</label>';

            }else{
                $check = '<label style="padding-right:15px;">';
                $check .= '<input type="checkbox" name="week" value="' . $key . '" /><span class="checkbox">' . $value.'</span>';
                $check .= '</label>';

            }

            $linecount++;
            if ($linecount >= 10) {
                $check .= '<br>';
                $linecount = 1;
            }

            $checkHtml .= $check;

        }

        return $checkHtml;
    }

}
