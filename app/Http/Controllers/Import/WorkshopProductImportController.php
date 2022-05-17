<?php

namespace App\Http\Controllers\Import;


use App\Http\Controllers\Controller;
use App\Models\Price;
use App\Models\WorkshopGroup;
use App\Models\WorkshopProduct;
use App\Models\WorkshopUnit;
use Box\Spout\Common\Type;
use Box\Spout\Reader\Common\Creator\ReaderFactory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class WorkshopProductImportController extends Controller
{
    public function import(){

        //機場8
        $shop_group_id = 8;
        $new_price_file_path = 'imports\hongkannewprice.xlsx';

        $this->newPriceInsert($shop_group_id, $new_price_file_path);

        $new_price_and_product_file_path = 'imports\hongkannewproductandprice.xlsx';

        $this->newProductAndPriceInsert($shop_group_id, $new_price_and_product_file_path);

        return 'success';
    }

    public function newPriceInsert($shop_group_id, $file_path)
    {
        $reader = ReaderFactory::createFromType(Type::XLSX);

        $reader->open($file_path);

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

//        dd($productArr);

        // 数据库事务处理
        DB::transaction(function() use($productArr, $shop_group_id){

            //插入產品
            $priceModel = new Price();
            $productno_id_array = WorkshopProduct::query()
                ->whereNotIn('status', [4])
                ->pluck('id', 'product_no')
                ->toArray();

            foreach ($productArr as $product){

                //插入,更新時間
                $now = Carbon::now()->toDateTimeString();

//                0 => array:11 [▼
//                    0 => 4101001
//                    1 => "罐裝可樂(24)"
//                    2 => "轉手貨"
//                    3 => "OEM-飲品"
//                    4 => "箱"
//                    5 => 86.38
//                    6 => 3
//                    7 => 1200
//                    8 => "0,1,2,3,4,5,6"
//                    9 => 1
//                    10 => 1
//                  ]

                $priceModel->insert([
                    'product_id' => $productno_id_array[$product[0]],

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

    public function newProductAndPriceInsert($shop_group_id, $file_path)
    {
        $reader = ReaderFactory::createFromType(Type::XLSX);

        $reader->open($file_path);

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
        DB::transaction(function() use($productArr, $shop_group_id){

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

                //保存關聯模型
                $productModel->prices()->save($price);

            }

        });

        $reader->close();
    }

}
