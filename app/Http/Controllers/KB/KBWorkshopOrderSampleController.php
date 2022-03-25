<?php

namespace App\Http\Controllers\KB;

use App\Http\Controllers\Controller;
use App\Models\KB\KBUser;
use App\Models\KB\KBWorkshopCat;
use App\Models\KB\KBWorkshopGroup;
use App\Models\KB\KBWorkshopOrderSample;
use App\Models\KB\KBWorkshopOrderSampleItem;
use App\Models\KB\KBWorkshopProduct;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class KBWorkshopOrderSampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function index()
    {
        $user = Auth::User();

//        //2021-03-01 獲取kb數據庫user表的id
//        $shopid = KBUser::where('rb_user_id',$user->id)->first()->id;
        $kb_bakery_id = $user->kb_bakery_id;
        $kb_kitchen_id = $user->kb_kitchen_id;
        $kb_waterbar_id = $user->kb_waterbar_id;

        $bakery_samples = $this->getSampleByType($kb_bakery_id);
        $kitchen_samples = $this->getSampleByType($kb_kitchen_id);
        $waterbar_samples = $this->getSampleByType($kb_waterbar_id);

        $all_samples['bakery']['samples'] = $bakery_samples;
        $all_samples['bakery']['name'] = '包部';
        $all_samples['bakery']['type'] = 'bakery';

        $all_samples['kitchen']['samples'] = $kitchen_samples;
        $all_samples['kitchen']['name'] = '廚房';
        $all_samples['kitchen']['type'] = 'kitchen';

        $all_samples['waterbar']['samples'] = $waterbar_samples;
        $all_samples['waterbar']['name'] = '水吧';
        $all_samples['waterbar']['type'] = 'waterbar';

//        dump($bakery_samples->toArray());
//        dump($kitchen_samples->toArray());
//        dump($all_samples);
//        return 1;
//        return view('kb.sample.index', compact('bakery_samples', 'kitchen_samples', 'waterbar_samples'));
        return view('kb.sample.index', compact('all_samples'));
    }

    public function create(KBWorkshopOrderSample $sample ,Request $request)
    {
        $type = $request->type;
        $shopid = User::getKBUserIDByType($type);
//        $shopid = $user->id;

        $cats = KBWorkshopCat::getSampleCats($request->type);

        $orderInfos = new Collection();

        $sampleModel = new KBWorkshopOrderSample();
        $sampledate = $sampleModel
            ->select(DB::raw('group_concat(sampledate) as sampledate'))
            ->where('user_id', $shopid)
            ->where('dept', $request->dept)
            ->where('disabled', 0)
            ->first()->sampledate;

        $checkHtml = $this->getCheckboxHtml($sampledate);

        $orderInfos->shop_name = KBUser::find($shopid)->txt_name;
        $orderInfos->dept_name = $request->dept;

//        dump($request->dept);
        return view('kb.sample.cart', compact( 'sample','cats',  'orderInfos' ,'checkHtml' ,'sampledate'));
    }

    public function edit(KBWorkshopOrderSample $sample)
    {
//        $user = Auth::User();
//
////        //2021-03-01 獲取kb數據庫user表的id
////        $shopid = KBUser::where('rb_user_id',$user->id)->first()->id;
//        $kb_bakery_id = $user->kb_bakery_id;
//        $kb_kitchen_id = $user->kb_kitchen_id;
//        $kb_waterbar_id = $user->kb_waterbar_id;
//
//        dump($kb_bakery_id);
//        dump($kb_kitchen_id);
//        dump($kb_waterbar_id);
//        dump($sample->toArray());
//        return 1;
//        dump($sample->toArray());
        $dept = $sample->dept;

        //2021-03-01 查詢是否有編輯權限
        $kb_user_id = $sample->user_id;

        $sample_info = $this->getSampleInfo($dept , $kb_user_id);

        $type = $sample_info['type'];
        $shopid = $sample_info['shop_id'];
//        dd($hasPermission);
        //2021-03-01 獲取kb數據庫user表的id
//        $user = Auth::User();
//
//        $shopid = $user->kb_bakery_id;

//        dump($hasPermission);
//        dump($dept);
        if($shopid === 0) throw new AccessDeniedHttpException('權限不足');
        //disabled範本不能查看
        if($sample->disabled === 1) throw new AccessDeniedHttpException('範本已刪除');

        $sampleModel = new KBWorkshopOrderSample();

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

        $cats = KBWorkshopCat::getSampleCats($type);

        $sampleItems = KBWorkshopOrderSample::getRegularOrderItems($shopid, $currentdate ,$sample->dept);

        $orderInfos = new Collection();

        $orderInfos->shop_name = KBUser::find($shopid)->txt_name;
        $orderInfos->dept_name = $sample->dept;

//        dump($sampleItems);
        return view('kb.sample.cart', compact( 'sample','cats', 'sampleItems', 'orderInfos' ,'checkHtml' ,'currentdate','sampleItems'));
    }

    public function store(Request $request)
    {
        $type = $request->type;
        $shopid = User::getKBUserIDByType($type);

        DB::transaction(function () use($request, $shopid){
            $insertDatas = json_decode($request->insertData, true);

//            dd($insertDatas);
            $sampleModel = new KBWorkshopOrderSample();
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

            $sampleItemModel = new KBWorkshopOrderSampleItem();
            $sampleItemModel::insert($sampleItemArr);
        });

    }


    public function update(Request $request, $sampleid)
    {
        DB::transaction(function () use($request ,$sampleid){

            $insertDatas = json_decode($request->insertData, true);
            $updateDatas = json_decode($request->updateData, true);
            $delDatas = json_decode($request->delData, true);

//            dd($insertDatas);
            $sampleModel = new KBWorkshopOrderSample();
            $sampleItemModel = new KBWorkshopOrderSampleItem();
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
        $sampleModel = new KBWorkshopOrderSample();
        $sampleModel::where('id',$sampleid)->update(['disabled' => 1]);
    }

    //ajax加載分組
    public function showGroup($catid)
    {
        $groups = KBWorkshopGroup::where('cat_id', $catid)->whereHas('products', function (Builder $query) {
            $query->whereHas('prices', function (Builder $query) {
                $query->where('shop_group_id', '=', KBWorkshopGroup::CURRENTGROUPID);
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
                $query->where('shop_group_id', '=', KBWorkshopGroup::CURRENTGROUPID);
            })
            //2020-02-25 產品排序
            ->orderBy('product_no')
            ->get();

        $group = KBWorkshopGroup::find($groupid);
        $infos = new Collection();
        $infos->group_name = $group->group_name;
        $infos->cat_name = $group->cats->cat_name;

        foreach ($products as $product) {

            $productDetail = $product->prices->where('shop_group_id', KBWorkshopGroup::CURRENTGROUPID)->first();

            $product->order_by_workshop = false;
            $product->cut_order = false;
            $product->not_deli_time = false;

            //判斷是否後台落單
            if ($productDetail->phase <= 0) {
                $product->order_by_workshop = true;
            }

            //todo 判斷跳過週末不出貨

            //只要有一個是true,分店就不能下單
            $product->invalid_order =
                $product->order_by_workshop ||
                $product->cut_order ||
                $product->not_deli_time;

            $this->resetProduct($product,$productDetail);

        }

        return view('kb.order.cart_product', compact('products','infos'))->render();
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

//    private function getShopidByRoles($dept ,$id, $type)
//    {
//        $user = Auth::User();
//
//        if(isset($type) && $dept == 'CU' && $user->can('shop')){
//            //2021-03-01 獲取kb數據庫user表的id
//            $shopid = KBUser::where('rb_user_id',$user->id)->first()->id;
//        }else{
//            return false;
//        }
//
//        return $shopid;
//    }

    //檢查是否有編輯權限, 並返回蛋撻王user ID
    private function getSampleInfo($dept ,$id)
    {
        $user = Auth::User();

        //2021-03-01 獲取kb數據庫user表的id
        $kb_bakery_id = $user->kb_bakery_id;
        $kb_kitchen_id = $user->kb_kitchen_id;
        $kb_waterbar_id = $user->kb_waterbar_id;

        $sample_info = [
            'type' => '',
            'shop_id' => 0,
        ];

        if($dept == 'CU' && $user->can('shop')){
            if($id == $kb_bakery_id){
                $sample_info['type'] = 'bakery';
                $sample_info['shop_id'] = $id;
            }else if($id == $kb_kitchen_id){
                $sample_info['type'] = 'kitchen';
                $sample_info['shop_id'] = $id;
            }else if($id == $kb_waterbar_id){
                $sample_info['type'] = 'waterbar';
                $sample_info['shop_id'] = $id;
            }
        }

        return $sample_info;
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

    }

    private function getSampleByType($id)
    {
        $sampleModel = new KBWorkshopOrderSample();
        $samples = $sampleModel
            ->select('id', 'sampledate','dept')
            ->where('user_id', $id)
            ->where('disabled', 0)
            ->get();

        foreach ($samples as $sample) {
            $sample->sampledate = $this->transSampleDate($sample->sampledate);
        }

        return $samples;

    }
}
