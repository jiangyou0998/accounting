<?php

namespace App\Http\Controllers;
use App\Models\Price;
use App\Models\ShopAddress;
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

}
