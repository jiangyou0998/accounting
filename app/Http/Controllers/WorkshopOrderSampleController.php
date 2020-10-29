<?php

namespace App\Http\Controllers;

use App\Models\WorkshopCat;
use App\Models\WorkshopGroup;
use App\Models\WorkshopOrderSample;
use App\Models\WorkshopOrderSampleItem;
use App\Models\WorkshopProduct;
use App\Models\WorkshopSample;
use App\User;
use Carbon\Carbon;
use Dcat\Admin\Grid\Column\Filter\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WorkshopOrderSampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function index()
    {
        $user = Auth::User();

        $shopid = $user->id;

        $sampleModel = new WorkshopOrderSample();
        $samples = $sampleModel
            ->select('id', 'sampledate','dept')
            ->where('user_id', $shopid)
            ->where('disabled', 0)
            ->get();

        foreach ($samples as $sample) {
            $sample->sampledate = $this->transSampleDate($sample->sampledate);

        }
//    dump($samples->toArray());
        return view('sample.index', compact('samples'));
    }

    public function regular(Request $request)
    {
        $shopid = $request->shopid;

        $shops = User::getRyoyuBakeryShops();

        $sampleModel = new WorkshopOrderSample();
        $samples = $sampleModel
            ->select('id', 'sampledate','dept')
            ->where('user_id', $shopid)
            ->where('disabled', 0)
            ->get();

        foreach ($samples as $sample) {
            $sample->sampledate = $this->transSampleDate($sample->sampledate);

        }
//    dump($samples->toArray());

        return view('sample.regular', compact('samples','shops'));
    }


    public function create(WorkshopOrderSample $sample ,Request $request)
    {
        $shopid = $this->getShopidByRoles($request);

        if($shopid === false){
            return '權限不足';
        }
//        $shopid = $user->id;

        $cats = WorkshopCat::getSampleCats($request->dept);

        $orderInfos = new Collection();

        $sampleModel = new WorkshopOrderSample();
        $sampledate = $sampleModel
            ->select(DB::raw('group_concat(sampledate) as sampledate'))
            ->where('user_id', $shopid)
            ->where('dept', $request->dept)
            ->where('disabled', 0)
            ->first()->sampledate;

        $checkHtml = $this->getCheckboxHtml($sampledate);

        $orderInfos->shop_name = User::find($shopid)->txt_name;
        $orderInfos->dept_name = $request->dept;

//        dump($request->dept);
        return view('sample.cart', compact( 'sample','cats',  'orderInfos' ,'checkHtml' ,'sampledate'));
    }

    public function edit(WorkshopOrderSample $sample)
    {
        $dept = $sample->dept;
        $shopid = $sample->user_id;

        $hasPermission = $this->checkEditPermission($dept , $shopid);

//        dump($hasPermission);
//        dump($dept);
        if($hasPermission === false) return '權限不足';
        //disabled範本不能查看
        if($sample->disabled === 1) return '範本已刪除';


        $sampleModel = new WorkshopOrderSample();

        $sampledate = $sampleModel
            ->select(DB::raw('group_concat(sampledate) as sampledate'))
            ->where('user_id', $shopid)
            ->where('id' ,'<>' , $sample->id)
            ->where('dept' , $dept)
            ->where('disabled', 0)
            ->first()->sampledate;

//        dump($sampledate);

        $currentdate = $sampleModel
            ->select(DB::raw('group_concat(sampledate) as sampledate'))
            ->where('user_id', $shopid)
            ->where('id'  , $sample->id)
            ->where('dept' , $dept)
            ->where('disabled', 0)
            ->first()->sampledate;

//        dump($currentdate);

        $checkHtml = $this->getCheckboxHtml($sampledate , $currentdate);

        $cats = WorkshopCat::getSampleCats($dept);

        $sampleItems = WorkshopSample::getRegularOrderItems($shopid, $currentdate ,$sample->dept);

        $orderInfos = new Collection();


        $orderInfos->shop_name = User::find($shopid)->txt_name;
        $orderInfos->dept_name = $sample->dept;

//        dump($sampleItems);
        return view('sample.cart', compact( 'sample','cats', 'sampleItems', 'orderInfos' ,'checkHtml' ,'currentdate','sampleItems'));
    }

    public function store(Request $request)
    {
        $user = Auth::User();
        if($request->dept == 'D' && $user->can('operation')){
            $shopid = $request->shopid;
        }else if(($request->dept == 'A' || $request->dept == 'B') && $user->can('shop')){
            $shopid = $user->id;
        }else{
            return '權限不足';
        }

        DB::transaction(function () use($request ,$shopid){
            $insertDatas = json_decode($request->insertData, true);

//            dd($insertDatas);
            $sampleModel = new WorkshopOrderSample();
            $sampleId = $sampleModel::insertGetId([
                'user_id' => $shopid,
                'sampledate' => $request->sampledate,
                'dept' => $request->dept,
                'disabled' => 0
            ]);

            $sampleItemArr = array();
            foreach ($insertDatas as $insertData){
                $sampleItemArr[] = [
                    'sample_id' => $sampleId,
                    'product_id' => $insertData['itemid'],
                    'qty' => $insertData['qty'],
                    'disabled' => 0
                ];
            }

            $sampleItemModel = new WorkshopOrderSampleItem();
            $sampleItemModel::insert($sampleItemArr);
        });

    }


    public function update(Request $request, $sampleid)
    {
        DB::transaction(function () use($request ,$sampleid){
            $user = Auth::User();
            $shopid = $user->id;
            $insertDatas = json_decode($request->insertData, true);
            $updateDatas = json_decode($request->updateData, true);
            $delDatas = json_decode($request->delData, true);

//            dd($insertDatas);
            $sampleModel = new WorkshopOrderSample();
            $sampleItemModel = new WorkshopOrderSampleItem();
            $sampleModel::where('id',$sampleid)->update(['sampledate' => $request->sampledate]);

            //插入
            $sampleItemArr = array();
            foreach ($insertDatas as $insertData){
                $sampleItemArr[] = [
                    'sample_id' => $sampleid,
                    'product_id' => $insertData['itemid'],
                    'qty' => $insertData['qty'],
                    'disabled' => 0
                ];
            }

            $sampleItemModel::insert($sampleItemArr);

            //更新
            foreach ($updateDatas as $updateData) {
                $sampleItemModel::where('id', $updateData['mysqlid'])->update(['qty' => $updateData['qty']]);
            }

            //刪除
            foreach ($delDatas as $delData) {
                $sampleItemModel::where('id', $delData['mysqlid'])->update(['disabled' => 1]);
            }

        });
    }

    public function destroy($sampleid)
    {
        $sampleModel = new WorkshopOrderSample();
        $sampleModel::where('id',$sampleid)->update(['disabled' => 1]);
    }

    public function showGroup($catid)
    {
        $groups = WorkshopGroup::where('cat_id', $catid)->get();

        return view('sample.cart_group', compact('groups'))->render();
    }

    public function showProduct($groupid, Request $request)
    {
        $products = WorkshopProduct::where('group_id', $groupid)->where('status', '!=', 4)->get();
//        dump($products);

        foreach ($products as $product) {

            $product->order_by_workshop = false;
            $product->cut_order = false;
            $product->not_deli_time = false;

            //判斷是否後台落單
            if ($product->phase <= 0) {
                $product->order_by_workshop = true;
            }

            //todo 判斷跳過週末不出貨

            //只要有一個是true,分店就不能下單
            $product->invalid_order =
                $product->order_by_workshop ||
                $product->cut_order ||
                $product->not_deli_time;

        }
//          dump($products->toArray());
        return view('sample.cart_product', compact('products'))->render();
    }

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
            if ($linecount >= 4) {
                $check .= '<br>';
                $linecount = 1;
            }

            $checkHtml .= $check;

        }

        return $checkHtml;
    }

    private function transSampleDate($sampledate)
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
            $sampledate = str_replace($key, $value, $sampledate);
        }

        return $sampledate;
    }

    private function getShopidByRoles($request)
    {
        $user = Auth::User();

        if($request->dept == 'D' && $user->can('operation')){
            $shopid = $request->shopid;
        }else if(($request->dept == 'A' || $request->dept == 'B') && $user->can('shop')){
            $shopid = $user->id;
        }else{
            return false;
        }

        return $shopid;
    }

    private function checkEditPermission($dept ,$shopid)
    {
        $user = Auth::User();

        if($dept == 'D' && $user->can('operation')){
            return true;
        }else if(($dept == 'A' || $dept == 'B') && $user->can('shop') && $shopid == $user->id){
            return true;
        }else{
            return false;
        }

    }
}
