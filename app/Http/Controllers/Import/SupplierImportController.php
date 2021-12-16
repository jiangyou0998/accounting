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

class SupplierImportController extends Controller
{
    public function importSupplierProduct()
    {
        $reader = ReaderFactory::createFromType(Type::XLSX);

        $filename = 'imports\SupplierProduct.xlsx';
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
            'tin' => '罐',
            'p' => '磅',
            'lb' => '磅',
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

                if($rowValues[0] == ''){
                    $rowValues[0] = $supplier;
                }else{
                    $supplier = $rowValues[0];
                    $supplierArr[] = $supplier;
                }

                $group = trim($rowValues[12]);
                $groupArr[] = $group;

                //true為不合法名稱
                $product_inavail = ($rowValues[2] == '非折扣項目總計'
                    || $rowValues[2] == "OEM產品總計"
                    || $rowValues[2] == "貨品名稱"
                    || $rowValues[2] == "");
//
//                $import_unit = $rowValues[3] ?? '';
//                $pos = mb_strrpos($import_unit, "/");
//                $base_unit = $rowValues[8] ?? '';
//
//
//                if($pos){
//                    $base_unit = $base_unit ?? mb_substr($import_unit, $pos - 1, 1);
//                    $unit = mb_substr($import_unit, $pos + 1);
//                }
//
////                dump($base_unit);

////                dump($base_unit);
///
                $import_unit = $rowValues[3];
                $base_unit = $rowValues[8];
                $pos = mb_strrpos($import_unit, "/");
                //默認以D列為單位,有斜杠時取斜杠後的
                $unit = $import_unit;
                if($pos){
                    $unit = mb_substr($import_unit, $pos + 1);
                }
//                //I列為0時, 用base_unit做單位
//                $base_unit = ($base_unit != 0) ? $base_unit : $unit;

                if(array_key_exists($base_unit, $changeUnitArr)){
                    $base_unit = $changeUnitArr[$base_unit];
                }

                if(array_key_exists($unit, $changeUnitArr)){
                    $unit = $changeUnitArr[$unit];
                }

                $base_unit = strtolower($base_unit);
                $unit = strtolower($unit);

                $rowValues['base_unit'] = $base_unit;
                $rowValues['unit'] = $unit;

                if( ! in_array($base_unit, $unitArr) && ! $product_inavail){
                    $unitArr[] = trim($base_unit);
                }

                if( ! in_array($unit, $unitArr) && ! $product_inavail){
                    $unitArr[] = trim($unit);
                }

                if($product_inavail) continue;

                $productArr[] = $rowValues;

            }
        }

//        dd($unitArr);
//        dd($productArr);
//        dd($supplierArr);
//        dd($groupArr);

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
                $supplierProductModel->product_name_short = $value[11];
                $supplierProductModel->product_no  = $value[1];
                $supplierProductModel->supplier_id = $supplierArr[$value[0]];
                $supplierProductModel->group_id = $groupArr[$value[12]];
                $supplierProductModel->unit_id = $unitArr[$value['unit']];
                //包裝單位ID
                $supplierProductModel->base_unit_id = $unitArr[$value['base_unit']];
                //包裝數量
                $supplierProductModel->base_qty  =  !empty($value[5]) ? $value[5] : 0;
                //每個包裝價格
                $supplierProductModel->base_price  = $value[9];
                //來貨價
                $supplierProductModel->default_price  = $value[4];
                $supplierProductModel->status = 0;
                $supplierProductModel->weight = !empty($value[7]) ? $value[7] : 0;
                $supplierProductModel->weight_unit = $value['base_unit'];
                $supplierProductModel->save();
            }

        });
    }


}
