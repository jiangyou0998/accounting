<?php

namespace App\Http\Controllers;
use App\Models\Price;
use App\Models\ShopAddress;
use App\Models\Supplier\Supplier;
use App\Models\Supplier\SupplierProduct;
use App\Models\WorkshopCat;
use App\Models\WorkshopGroup;
use App\Models\WorkshopProduct;
use App\Models\WorkshopUnit;
use App\User;
use Box\Spout\Common\Type;
use Box\Spout\Reader\Common\Creator\ReaderFactory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ImportController extends Controller
{

    //todo 10月13日討論完再做
    public function import()
    {
        $reader = ReaderFactory::createFromType(Type::XLSX);

        $reader->open('importExcel.xlsx');

        $arr = array();

        foreach ($reader->getSheetIterator() as $sheet) {
//            dump($sheet);
            $catArr = array();
            $groupArr = array();
            $productArr = array();

            foreach ($sheet->getRowIterator() as $rowKey => $row) {
                // do stuff with the row
                if($rowKey == 1) continue;
                $rowValues = $row->toArray();

                //大類數組
                if(!in_array($rowValues[0],$catArr)){
                    array_push($catArr,$rowValues[0]);
                }

                //細類數組
                if (!isset($groupArr[$rowValues[0]])){
                    $groupArr[$rowValues[0]][] = $rowValues[1];
                }else {
                    if (!in_array($rowValues[1], $groupArr[$rowValues[0]])) {
                        $groupArr[$rowValues[0]][] = $rowValues[1];
                    }
                }

                //產品數組
                $productArr[] = $rowValues;

            }
        }


//        foreach ($productArr as &$product){
//            $product[9] = Str::before($product[9],'天前');
//            $product[10] = Carbon::parse($product[10])->isoFormat('HHmm');
//        }

        // 数据库事务处理
        DB::transaction(function() use($catArr,$groupArr,$productArr){
            //插入大類
            $catModel = new WorkshopCat();
            $cat_sort = 100;
            foreach ($catArr as $cat) {
                $catModel->insert([
                    'cat_name' => $cat,
                    'sort' => $cat_sort,
                    'status' => 1,
                    'int_page' => 1,
                ]);
                $cat_sort += 100;
            }

            //插入細類
            $groupModel = new WorkshopGroup();
            $group_sort = 100;
            foreach ($groupArr as $cat => $groups) {
                $cat_id = $catModel->where('cat_name',$cat)->first()->id;

                foreach ($groups as $group) {
                    $short_name = Str::after($group,'-');
                    $groupModel->insert([
                        'group_name' => $group,
                        'sort' => $group_sort,
                        'status' => 1,
                        'cat_id'=>$cat_id,
                        'short_name' => $short_name,
                    ]);
                    $group_sort += 100;
                }
            }

            //插入產品
            $productModel = new WorkshopProduct();
            $unitModel = new WorkshopUnit();
            $product_sort = 100;
            foreach ($productArr as $product){
                //細類id
                $group_id = $groupModel->where('group_name',$product[1])->first()->id;
                //單位id
                $unit_id = $unitModel->where('unit_name',$product[4])->first()->id;
                //插入,更新時間
                $now = Carbon::now()->toDateTimeString();

//                0 => array:14 [
//                    0 => "熟細包"
//                    1 => "細包-湯種"
//                    2 => "A10001"
//                    3 => "月島軟心芝士餃子"
//                    4 => "個"
//                    5 => 15
//                    6 => 50
//                    7 => "報表1"
//                    8 => "熟細包"
//                    9 => "2天前"
//                    10 => "1200"
//                    11 => 10
//                    12 => 10
//                    13 => "0,1,2,3,4,5,6"
//                  ]

                $productModel->insert([
                    'group_id' => $group_id,
                    'product_no' => $product[2],
                    'product_name' => $product[3],
                    'unit_id' => $unit_id,
                    'default_price' => $product[5],
                    'weight' => $product[6],
                    'phase' => Str::before($product[9],'天前'),
                    'cuttime' => Carbon::parse($product[10])->isoFormat('HHmm'),
                    'min' => $product[11],
                    'base' => $product[12],
                    'canordertime' => $product[13],
                    'selling_price' => $product[14],
                    'cost_price' => $product[15],
                    'sort' => $product_sort,
                    'status' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
                $product_sort += 100;

            }

        });

        dump($catArr);
        dump($groupArr);
        dump($productArr);
        $reader->close();
    }

    public function importRyoyuPrice()
    {
        $reader = ReaderFactory::createFromType(Type::XLSX);

        $reader->open('ryoyuimport.xlsx');

        foreach ($reader->getSheetIterator() as $sheet) {

            foreach ($sheet->getRowIterator() as $rowKey => $row) {
                // do stuff with the row
                if($rowKey == 1) continue;
                $rowValues = $row->toArray();

                if($rowValues[8] == "") continue;

                //產品數組
                $productArr[] = $rowValues;

            }
        }

//        dump($productArr);

        // 数据库事务处理
        DB::transaction(function() use($productArr){

            //插入產品
            $priceModel = new Price();
            foreach ($productArr as $product){

                //插入,更新時間
                $now = Carbon::now()->toDateTimeString();

//                0 => array:9 [▼
//                    0 => "914"
//                    1 => "1103001"
//                    2 => "奶油反卷方包"
//                    3 => 27
//                    4 => "2"
//                    5 => "1000"
//                    6 => "0,1,2,3,4,5,6"
//                    7 => 4
//                    8 => 4
//                  ]

                $priceModel->insert([
                    'product_id' => $product[0],
                    //糧友group_id 5
                    'shop_group_id' => 5,
                    'price' => $product[3],
                    'phase' => $product[4],
                    'cuttime' => $product[5],
                    'canordertime' => $product[6],
                    'min' => $product[7],
                    'base' => $product[8],
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);

            }

        });

        $reader->close();
    }

    public function importNewRyoyuProductAndPrice()
    {
        $reader = ReaderFactory::createFromType(Type::XLSX);

        $reader->open('ryoyunew.xlsx');


        $groups = WorkshopGroup::all()->pluck('id','group_name');
        $units = WorkshopUnit::all()->pluck('id','unit_name');

        foreach ($reader->getSheetIterator() as $sheet) {

            foreach ($sheet->getRowIterator() as $rowKey => $row) {
                // do stuff with the row
                if($rowKey == 1) continue;
                $rowValues = $row->toArray();

                //分組名轉化成分組id
                $rowValues[3] = $groups[$rowValues[3]];
                //單位名轉化成單位id
                $rowValues[4] = $units[$rowValues[4]];

                //產品數組
                $productArr[] = $rowValues;

            }
        }

//        dd($productArr);

        // 数据库事务处理
        DB::transaction(function() use($productArr){

            //插入產品
            $productModel = new WorkshopProduct();
            $priceModel = new Price();

            foreach ($productArr as $product){

                //插入,更新時間
                $now = Carbon::now()->toDateTimeString();

//                 0 => array:11 [▼
//                    0 => 1102012
//                    1 => "日本湯種-英式方包"
//                    2 => "麵包部"
//                    3 => "熟包-方包"
//                    4 => "條"
//                    5 => 27
//                    6 => 2
//                    7 => 1000
//                    8 => "0,1,2,3,4,5,6"
//                    9 => 1
//                    10 => 1
//                  ]

                $productModel = WorkshopProduct::create([
                    'product_no' => $product[0],
                    'product_name' => $product[1],
                    'group_id' => $product[3],
                    'unit_id' => $product[4],
                    'sort' => 999,
                    'status' => 1,
                    'last_modify' => 'Insert in '.$now,
                ]);

                $price = new Price([
                    //糧友group_id 5
                    'shop_group_id' => 5,
                    'price' => $product[5],
                    'phase' => $product[6],
                    'cuttime' => $product[7],
                    'canordertime' => $product[8],
                    'min' => $product[9],
                    'base' => $product[10],
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);

                //保存關聯模型
                $productModel->prices()->save($price);

            }

        });

        $reader->close();
    }

    //導入外客賬號以及地址
    public function importCustomer(){
        $reader = ReaderFactory::createFromType(Type::XLSX);

        $reader->open('imports\customer.xlsx');

        $sort = 300;

        foreach ($reader->getSheetIterator() as $sheet) {

            foreach ($sheet->getRowIterator() as $rowKey => $row) {
                // do stuff with the row
                if($rowKey == 1) continue;
                $rowValues = $row->toArray();

                //產品數組
                $resultArr[] = $rowValues;
//                dump($rowValues);

                $user = new User();
                $user->name = 'cu'.($rowValues[0] ?? '');
                $user->password = Hash::make('xm95jw');
                $user->txt_name = $rowValues[1] ?? '';
                $user->report_name = $rowValues[6] ?? '';
                $user->type = 2;
                $user->sort = $sort;
                $user->company_chinese_name = $rowValues[9] ?? '';
                $user->company_english_name = $rowValues[10] ?? '';
                $user->pocode = $rowValues[0] ?? '';

                $address = new ShopAddress();
                $address->shop_name = $rowValues[1] ?? '';
                $address->tel = $rowValues[3] ?? '';
                $address->fax = $rowValues[4] ?? '';
                $address->address = $rowValues[7] ?? '';
                $address->eng_address = $rowValues[8] ?? '';

                $address->save();
                $address->users()->save($user);

                $sort++;
            }
        }



//        dump($resultArr);
    }

    //導入外客價格
    public function importCustomerPrice()
    {
        $array = [
            4 => 'imports\erhao.xlsx',
            6 => 'imports\jinji.xlsx',
            7 => 'imports\minhua.xlsx',
            8 => 'imports\jichang.xlsx',
            9 => 'imports\mantai.xlsx',
            10 => 'imports\togathercafe.xlsx',
        ];

        foreach ($array as $shop_group_id => $filename){
            $this->importPrice($shop_group_id,$filename);
        }

        return 'success';
    }

    public function importPrice($shop_group_id,$filename)
    {
        $reader = ReaderFactory::createFromType(Type::XLSX);

        $reader->open($filename);

        foreach ($reader->getSheetIterator() as $sheet) {

            foreach ($sheet->getRowIterator() as $rowKey => $row) {
                // do stuff with the row
                if($rowKey == 1) continue;
                $rowValues = $row->toArray();
                //dd($rowValues);
                if(!isset($rowValues[6]) || $rowValues[6] == "") continue;

                //產品數組
                $productArr[] = $rowValues;

            }
        }

//        dd($productArr);

        // 数据库事务处理
        DB::transaction(function() use($productArr ,$shop_group_id){

            //插入產品
            $priceModel = new Price();
            foreach ($productArr as $product){

                //插入,更新時間
                $now = Carbon::now()->toDateTimeString();

//                0 => array:9 [▼
//                    0 => "914"
//                    1 => "1103001"
//                    2 => "奶油反卷方包"
//                    3 => 27
//                    4 => "2"
//                    5 => "1000"
//                    6 => "0,1,2,3,4,5,6"
//                    7 => 4
//                    8 => 4
//                  ]

                $priceModel->insert([
                    'product_id' => $product[0],
                    //糧友group_id 5
                    'shop_group_id' => $shop_group_id,
                    'price' => $product[5],
                    'phase' => $product[6],
                    'cuttime' => $product[7],
                    'canordertime' => $product[8],
                    'min' => $product[9],
                    'base' => $product[10],
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);

            }

        });

        $reader->close();
    }

    public function resetPrice(){

        $reader = ReaderFactory::createFromType(Type::XLSX);

        $reader->open('imports\Price.xlsx');

        foreach ($reader->getSheetIterator() as $sheet) {

            foreach ($sheet->getRowIterator() as $rowKey => $row) {
                // do stuff with the row
                if($rowKey == 1) continue;
                $rowValues = $row->toArray();
//dump($rowValues);
                if(!isset($rowValues[5]) || $rowValues[5] == '') continue;

                //產品數組
                $priceArr[$rowValues[0]] = $rowValues[5];

            }
        }
//        dd($priceArr);

        DB::transaction(function() use($priceArr){

//            $priceModel = new Price();
            foreach ($priceArr as $id => $price){
                $priceModel = Price::find($id);
                $priceModel->price = $price;
                $priceModel->save();
            }
        });

        return 'success';
    }

//    public function importSupplierItems()
//    {
//        $reader = ReaderFactory::createFromType(Type::XLSX);
//
//        $reader->open('imports\supplierimport.xlsx');
//
//        $supplierArr = [];
//        $catArr = [];
//
//        $unitArr = WorkshopUnit::all()->pluck( 'id','unit_name')->toArray();
//        dump($unitArr);
//
//        foreach ($reader->getSheetIterator() as $sheet) {
//
//            foreach ($sheet->getRowIterator() as $rowKey => $row) {
//                // do stuff with the row
////                if($rowKey == 1) continue;
//                $rowValues = $row->toArray();
//
//                $pos = mb_strrpos($rowValues[6], "/");
//
//                $min_unit = $rowValues[6];
//                $unit = $rowValues[6];
//
//                if($pos){
//                    $min_unit = $rowValues[10] = mb_substr($rowValues[6], $pos - 1, 1);
//                    $unit = $rowValues[6] = mb_substr($rowValues[6], $pos + 1, 1);
//                }
//                if($unit === '箱'){
////                    print_r($min_unit);
//                }
//
//
//                if (!in_array($rowValues[8], $supplierArr)) {
//                    $supplierArr[] = $rowValues[8];
//                }
//
//                if (!in_array($rowValues[9], $catArr)) {
//                    $catArr[] = $rowValues[9];
//                }
//
//                //產品數組
//                $productArr[] = $rowValues;
//
//            }
//        }
//
//        foreach ($productArr as $key => &$value){
//
//            if($value[6] !== '箱'){
//                $value[10] = $value[6];
//            }else{
//                if( $key > 0 && $value[0] === $productArr[$key-1][0]){
//                    $value[10] = $productArr[$key-1][6];
//                }else{
////                    dump($value[0].'/'.$value[6].'/'.$value[10]);
//                }
//            }
////            dump($value[0].'/'.$value[6].'/'.$value[10]);
//        }
//
//        foreach ($productArr as $key => &$value){
//
//            $value[6] = $unitArr[$value[6]] ?? 0;
//            $value[10] = $unitArr[$value[10]] ?? 0;
//
//            if($value[6] == "" || $value[10] == "")
//            dump($value[0].'/'.$value[6].'/'.$value[10]);
//        }
//
////        dump($supplierArr);
////        dump($catArr);
////        dump($productArr);
//
////        0 => array:11 [▼
////            0 => "8150001"
////            1 => "星牌氣仔(Gas)"
////            2 => 0
////            3 => "x"
////            4 => 0
////            5 => 0
////            6 => 14
////            7 => 11
////            8 => "鴻發號"
////            9 => "消耗品"
////            10 => 14
////          ]
//
//
//        // 数据库事务处理
//        DB::transaction(function() use($productArr){
//
//            foreach ($productArr as $key => $value){
//                $supplierProductModel = new SupplierProduct();
//                $supplierProductModel->product_name = $value[1];
//                $supplierProductModel->product_no  = $value[0];
//                $supplierProductModel->supplier_id = 1;
//                $supplierProductModel->group_id = 1;
//                $supplierProductModel->unit_id = $value[6];
//                $supplierProductModel->base_unit_id = $value[10];
//                $supplierProductModel->base_qty  = $value[2];
//                $supplierProductModel->default_price  = $value[7];
//                $supplierProductModel->disabled = 0;
//                $supplierProductModel->weight = $value[4];
//                $supplierProductModel->weight_unit = $value[5];
//                $supplierProductModel->save();
//            }
//
//        });
//
//        $reader->close();
//
//        return 'success';
//    }

    public function importSupplierProduct()
    {
        $reader = ReaderFactory::createFromType(Type::XLSX);

        $filename = 'imports\Data1.xlsx';
        $reader->open($filename);

        $supplier = '';
        $supplierArr = [];
        $unitArr = [];

        $changeUnitArr = [
            'bag' => '袋',
            'bot' => '瓶',
            'btl' => '樽',
            'buck' => '桶',
            'can' => '罐',
            'case' => '盒',
            'cs' => '箱',
            'ctn' => '箱',
            'gallon' => '加侖',
            'pail' => '桶',
            'pk' => '包',
            'pkt' => '包',
            'roll' => '卷',
            'sac' => '袋',
            'tin' => '罐'
        ];

        foreach ($changeUnitArr as $english_name => $chinese_name){
            $changeUnitArr[$english_name.'s'] = $chinese_name;
        }

//        dd($changeUnitArr);

        foreach ($reader->getSheetIterator() as $sheet) {

            foreach ($sheet->getRowIterator() as $rowKey => $row) {
                // do stuff with the row
                if($rowKey == 1) continue;
                $rowValues = $row->toArray();

                $sum = 0;
                for($i = 10; $i <= 32; $i++){
                    if(!isset($rowValues[$i]) || $rowValues[$i] == "") continue;
                    $sum += $rowValues[$i];
                }

                $rowValues['sum'] = $sum;

                //dd($rowValues);
//                if(!isset($rowValues[6]) || $rowValues[6] == "") continue;

                //產品數組
//                if(end($rowValues) > 0){
//                    $productArr[] = $rowValues;
//                }

                if($rowValues[0] == ''){
                    $rowValues[0] = $supplier;
                }else{
                    $supplier = $rowValues[0];
                    $supplierArr[] = $supplier;
                }

                //true為不合法名稱
                $product_inavail = ($rowValues[2] == '非折扣項目總計'
                    || $rowValues[2] == "OEM產品總計"
                    || $rowValues[2] == "貨品名稱"
                    || $rowValues[2] == "");

                $import_unit = $rowValues[3];
                $pos = mb_strrpos($import_unit, "/");
                $min_unit = $rowValues[8];
                $unit = $import_unit;

                if($pos){
//                    $min_unit  = mb_substr($import_unit, $pos - 1, 1);
                    $unit = mb_substr($import_unit, $pos + 1);
                }

                $min_unit = strtolower($min_unit);
                $unit = strtolower($unit);

                if(array_key_exists($min_unit, $changeUnitArr)){
                    $min_unit = $changeUnitArr[$min_unit];
                }

                if(array_key_exists($unit, $changeUnitArr)){
                    $unit = $changeUnitArr[$unit];
                }

                $rowValues['min_unit'] = $min_unit;
                $rowValues['unit'] = $unit;

                if( ! in_array($min_unit, $unitArr) && ! $product_inavail){
                    $unitArr[] = $min_unit;
                }

                if( ! in_array($unit, $unitArr) && ! $product_inavail){
                    $unitArr[] = $unit;
                }



                if($product_inavail) continue;

                $productArr[] = $rowValues;

            }
        }

//        dd($unitArr);
//        dd($productArr);
//        dump($supplierArr);

        $this->importUnits($unitArr);
        $this->importSuppliers($supplierArr);
        $this->importSupplierProductItems($productArr);

        $reader->close();

        return 'success';
    }

    public function importSuppliers($supplierArr){
        DB::transaction(function() use($supplierArr){
            foreach ($supplierArr as $supplier){
                Supplier::firstOrCreate(array('name' => $supplier));
            }
        });
    }

    public function importUnits($unitArr){
        DB::transaction(function() use($unitArr){
            foreach ($unitArr as $unit){
                WorkshopUnit::firstOrCreate(array('unit_name' => $unit));
            }
        });
    }

    public function importSupplierProductItems($productArr){
        // 数据库事务处理
        DB::transaction(function() use($productArr){

            $unitArr = WorkshopUnit::all()->pluck('id', 'unit_name')->toArray();
            $supplierArr = Supplier::all()->pluck('id', 'name')->toArray();

            foreach ($productArr as $key => $value){
                $supplierProductModel = new SupplierProduct();
                $supplierProductModel->product_name = $value[2];
                $supplierProductModel->product_name_short = $value[2];
                $supplierProductModel->product_no  = $value[1];
                $supplierProductModel->supplier_id = $supplierArr[$value[0]];
                $supplierProductModel->group_id = 1;
                $supplierProductModel->unit_id = $unitArr[$value['unit']];
                $supplierProductModel->base_unit_id = $unitArr[$value['min_unit']];
                $supplierProductModel->base_qty  = $value[5] ?? 0;
                $supplierProductModel->default_price  = $value[4];
                $supplierProductModel->status = $value['sum'] > 0 ? 0 : 1;
                $supplierProductModel->weight = $value[7] ?? 0;
                $supplierProductModel->weight_unit = $value[8];
                $supplierProductModel->save();
            }

        });
    }

}
