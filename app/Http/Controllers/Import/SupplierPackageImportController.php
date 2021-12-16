<?php

namespace App\Http\Controllers\Import;
use App\Http\Controllers\Controller;
use App\Models\Supplier\Supplier;
use App\Models\Supplier\SupplierProduct;
use App\Models\SupplierGroup;
use App\Models\WorkshopUnit;
use Box\Spout\Common\Type;
use Box\Spout\Reader\Common\Creator\ReaderFactory;
use Illuminate\Support\Facades\DB;

class SupplierPackageImportController extends Controller
{
    public function importSupplierProduct()
    {
        $reader = ReaderFactory::createFromType(Type::XLSX);

        $filename = 'imports\Data3.xlsx';
        $reader->open($filename);

        $supplier = '';
        $supplierArr = [];
        $unitArr = [];
        $groupArr = [];

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

//                $sum = 0;
//                for($i = 5; $i <= 27; $i++){
//                    if(!isset($rowValues[$i]) || $rowValues[$i] == "") continue;
//                    $sum += $rowValues[$i];
//                }
//
//                $rowValues['sum'] = $sum;

                //dd($rowValues);
//                if(!isset($rowValues[6]) || $rowValues[6] == "") continue;

                //產品數組
//                if(end($rowValues) > 0){
//                    $productArr[] = $rowValues;
//                }

                if($rowValues[0] == '' || $rowValues[0] == '1000張/扎'){
                    $rowValues[0] = $supplier;
                }else{
                    $supplier = $rowValues[0];
                    $supplierArr[] = $supplier;
                }

                $group = trim($rowValues[6]);
                $groupArr[] = $group;

                //true為不合法名稱
                $product_inavail = ($rowValues[2] == '非折扣項目總計'
                    || $rowValues[2] == "OEM產品總計"
                    || $rowValues[2] == "貨品名稱"
                    || $rowValues[2] == "");

                $import_unit = $rowValues[3];
                $pos = mb_strrpos($import_unit, "/");
                $unit = $import_unit;

                if($pos){
                    $unit = mb_substr($import_unit, $pos + 1);
                }

                $unit = strtolower($unit);

                if(array_key_exists($unit, $changeUnitArr)){
                    $unit = $changeUnitArr[$unit];
                }

                $rowValues['unit'] = $unit;

                if( ! in_array($unit, $unitArr) && ! $product_inavail){
                    $unitArr[] = trim($unit);
                }

                if($product_inavail) continue;

                $productArr[] = $rowValues;

            }
        }

//        dd($unitArr);
//        dump($productArr);
//        dump($supplierArr);

        $this->importUnits($unitArr);
        $this->importSuppliers($supplierArr);
        $this->importGroups($groupArr);
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

    public function importGroups($groupArr){
        DB::transaction(function() use($groupArr){
            foreach ($groupArr as $group){
                SupplierGroup::firstOrCreate(array('name' => $group));
            }
        });
    }

    public function importSupplierProductItems($productArr){
        // 数据库事务处理
        DB::transaction(function() use($productArr){

            $unitArr = WorkshopUnit::all()->pluck('id', 'unit_name')->toArray();
            $supplierArr = Supplier::all()->pluck('id', 'name')->toArray();
            $groupArr = SupplierGroup::all()->pluck('id', 'name')->toArray();


            foreach ($productArr as $key => $value){
                $supplierProductModel = new SupplierProduct();
                $supplierProductModel->product_name = $value[2];
                $supplierProductModel->product_name_short = $value[2];
                $supplierProductModel->product_no  = $value[1];
                $supplierProductModel->supplier_id = $supplierArr[$value[0]];
                $supplierProductModel->group_id = $groupArr[$value[6]];
                $supplierProductModel->unit_id = $unitArr[$value['unit']];
//                $supplierProductModel->base_unit_id = 0;
//                $supplierProductModel->base_qty  = 0;
                $supplierProductModel->default_price  = $value[4];
                $supplierProductModel->status = 0;
//                $supplierProductModel->weight = $value[7] ?? 0;
//                $supplierProductModel->weight_unit = $value[8];
                $supplierProductModel->save();
            }

        });
    }

//    public function importSupplierProduct()
//    {
//        $reader = ReaderFactory::createFromType(Type::XLSX);
//
//        $filename = 'imports\Data3.xlsx';
//        $reader->open($filename);
//
//        $supplier = '';
//        $supplierArr = [];
//        $unitArr = [];
//
//        $changeUnitArr = [
//            'bag' => '袋',
//            'bot' => '瓶',
//            'btl' => '樽',
//            'buck' => '桶',
//            'can' => '罐',
//            'case' => '盒',
//            'cs' => '箱',
//            'ctn' => '箱',
//            'gallon' => '加侖',
//            'pail' => '桶',
//            'pk' => '包',
//            'pkt' => '包',
//            'roll' => '卷',
//            'sac' => '袋',
//            'tin' => '罐'
//        ];
//
//        foreach ($changeUnitArr as $english_name => $chinese_name){
//            $changeUnitArr[$english_name.'s'] = $chinese_name;
//        }
//
////        dd($changeUnitArr);
//
//        foreach ($reader->getSheetIterator() as $sheet) {
//
//            foreach ($sheet->getRowIterator() as $rowKey => $row) {
//                // do stuff with the row
//                if($rowKey == 1) continue;
//                $rowValues = $row->toArray();
//
//                $sum = 0;
//                for($i = 5; $i <= 27; $i++){
//                    if(!isset($rowValues[$i]) || $rowValues[$i] == "") continue;
//                    $sum += $rowValues[$i];
//                }
//
//                $rowValues['sum'] = $sum;
//
//                //dd($rowValues);
////                if(!isset($rowValues[6]) || $rowValues[6] == "") continue;
//
//                //產品數組
////                if(end($rowValues) > 0){
////                    $productArr[] = $rowValues;
////                }
//
//                if($rowValues[0] == '' || $rowValues[0] == '1000張/扎'){
//                    $rowValues[0] = $supplier;
//                }else{
//                    $supplier = $rowValues[0];
//                    $supplierArr[] = $supplier;
//                }
//
//                //true為不合法名稱
//                $product_inavail = ($rowValues[2] == '非折扣項目總計'
//                    || $rowValues[2] == "OEM產品總計"
//                    || $rowValues[2] == "貨品名稱"
//                    || $rowValues[2] == "");
//
//                $import_unit = $rowValues[3];
//                $pos = mb_strrpos($import_unit, "/");
//                $unit = $import_unit;
//
//                if($pos){
//                    $unit = mb_substr($import_unit, $pos + 1);
//                }
//
//                $unit = strtolower($unit);
//
//                if(array_key_exists($unit, $changeUnitArr)){
//                    $unit = $changeUnitArr[$unit];
//                }
//
//                $rowValues['unit'] = $unit;
//
//                if( ! in_array($unit, $unitArr) && ! $product_inavail){
//                    $unitArr[] = $unit;
//                }
//
//                if($product_inavail) continue;
//
//                $productArr[] = $rowValues;
//
//            }
//        }
//
////        dump($unitArr);
////        dump($productArr);
////        dump($supplierArr);
//
//        $this->importUnits($unitArr);
//        $this->importSuppliers($supplierArr);
//        $this->importSupplierProductItems($productArr);
//
//        $reader->close();
//
//        return 'success';
//    }
//
//    public function importSuppliers($supplierArr){
//        DB::transaction(function() use($supplierArr){
//            foreach ($supplierArr as $supplier){
//                Supplier::firstOrCreate(array('name' => $supplier));
//            }
//        });
//    }
//
//    public function importUnits($unitArr){
//        DB::transaction(function() use($unitArr){
//            foreach ($unitArr as $unit){
//                WorkshopUnit::firstOrCreate(array('unit_name' => $unit));
//            }
//        });
//    }
//
//    public function importSupplierProductItems($productArr){
//        // 数据库事务处理
//        DB::transaction(function() use($productArr){
//
//            $unitArr = WorkshopUnit::all()->pluck('id', 'unit_name')->toArray();
//            $supplierArr = Supplier::all()->pluck('id', 'name')->toArray();
//
//            foreach ($productArr as $key => $value){
//                $supplierProductModel = new SupplierProduct();
//                $supplierProductModel->product_name = $value[2];
//                $supplierProductModel->product_name_short = $value[2];
//                $supplierProductModel->product_no  = $value[1];
//                $supplierProductModel->supplier_id = $supplierArr[$value[0]];
//                $supplierProductModel->group_id = 1;
//                $supplierProductModel->unit_id = $unitArr[$value['unit']];
////                $supplierProductModel->base_unit_id = 0;
////                $supplierProductModel->base_qty  = 0;
//                $supplierProductModel->default_price  = $value[4];
//                $supplierProductModel->status = $value['sum'] > 0 ? 0 : 1;
////                $supplierProductModel->weight = $value[7] ?? 0;
////                $supplierProductModel->weight_unit = $value[8];
//                $supplierProductModel->save();
//            }
//
//        });
//    }

}
