<?php

namespace App\Http\Controllers;
use App\Models\WorkshopCat;
use App\Models\WorkshopGroup;
use App\Models\WorkshopProduct;
use App\Models\WorkshopUnit;
use Box\Spout\Common\Type;
use Box\Spout\Reader\Common\Creator\ReaderFactory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
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

}
