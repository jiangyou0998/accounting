<?php

namespace App\Http\Controllers\Import;


use App\Http\Controllers\Controller;
use App\Models\Supplier\Supplier;
use App\Models\SupplierGroup;
use App\Models\WarehouseGroup;
use App\Models\WarehouseProduct;
use App\Models\WarehouseProductPrice;
use App\Models\WorkshopUnit;
use Box\Spout\Common\Type;
use Box\Spout\Reader\Common\Creator\ReaderFactory;
use Illuminate\Support\Facades\DB;

class WarehouseProductImportController extends Controller
{
    public function importProduct()
    {
        $reader = ReaderFactory::createFromType(Type::XLSX);

        $filename = 'imports\warehousedata.xlsx';
        $reader->open($filename);

        $supplier = '';
        $supplierArr = [];
        $unitArr = [];
        $groupArr = [];
        $warehouseGroupArr = [];

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

                $group = trim($rowValues[10]);
//                if($group == ''){
//                    $group = '其他';
//                }
                $groupArr[] = $group;

                if($rowValues[12] == ''){
                    $rowValues[12] = '其他';
                }
                $warehouse_group = trim($rowValues[12]);
                $warehouseGroupArr[] = $warehouse_group;

                //true為不合法名稱
                $product_inavail = ($rowValues[2] == '非折扣項目總計'
                    || $rowValues[2] == "OEM產品總計"
                    || $rowValues[2] == "貨品名稱"
                    || $rowValues[2] == "");

                $import_unit = $rowValues[3];
                $pos = mb_strrpos($import_unit, "/");
                $min_unit = $rowValues[14];
                $unit = $import_unit;

                if($pos){
                    $min_unit = $min_unit ?? mb_substr($import_unit, $pos - 1, 1);
                    $unit = mb_substr($import_unit, $pos + 1);
                }

                $min_unit = is_string($min_unit) ? strtolower($min_unit) : '';
                $unit = is_string($unit) ? strtolower($unit) : '';

//                dump($min_unit);
                if(array_key_exists($min_unit, $changeUnitArr)){
                    $min_unit = $changeUnitArr[$min_unit];
                }

                if(array_key_exists($unit, $changeUnitArr)){
                    $unit = $changeUnitArr[$unit];
                }

                $rowValues['min_unit'] = $min_unit;
                $rowValues['unit'] = $unit;

                if( ! in_array($min_unit, $unitArr) && ! $product_inavail){
                    $unitArr[] = trim($min_unit);
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

        $this->importUnits($unitArr);
        $this->importSuppliers($supplierArr);
        $this->importGroups($groupArr);
        $this->importWarehouseGroups($warehouseGroupArr);
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

    public function importWarehouseGroups($groupArr){
        DB::transaction(function() use($groupArr){
            foreach ($groupArr as $group){
                WarehouseGroup::firstOrCreate(array('name' => $group));
            }
        });
    }

    public function importSupplierProductItems($productArr){
        // 数据库事务处理
        DB::transaction(function() use($productArr){

            $unitArr = WorkshopUnit::all()->pluck('id', 'unit_name')->toArray();
            $supplierArr = Supplier::all()->pluck('id', 'name')->toArray();
            $groupArr = SupplierGroup::all()->pluck('id', 'name')->toArray();
            $warehGroupArr = WarehouseGroup::all()->pluck('id', 'name')->toArray();

            foreach ($productArr as $key => $value){
                $warehouseProductModel = new WarehouseProduct();
                $warehouseProductModel->product_name = $value[2];
                $warehouseProductModel->product_name_short = $value[9];
                $warehouseProductModel->product_no  = $value[1];
                $warehouseProductModel->supplier_id = $supplierArr[$value[0]];
                $warehouseProductModel->group_id = $groupArr[$value[10]];
                $warehouseProductModel->unit_id = $unitArr[$value['unit']];
                $warehouseProductModel->base_unit_id = $unitArr[$value['min_unit']];
                $warehouseProductModel->base_qty  = ($value[5] != '') ? $value[5] : 0;
                $warehouseProductModel->default_price  = $value[4];
                $warehouseProductModel->status = 0;
                $warehouseProductModel->weight = ($value[7] != '') ? $value[7] : null;
                $warehouseProductModel->weight_unit = ($value[8] != '') ? $value[8] : null;
                $warehouseProductModel->warehouse_group_id = $warehGroupArr[$value[12]];
                $warehouseProductModel->save();
                $warehouseProductModel->prices()->saveMany([
                    new WarehouseProductPrice([
                        'price' => is_numeric($value[4]) ? $value[4] : 0,
                        'base_price' => is_numeric($value[15]) ? $value[15] : 0,
                        'sort' => 1,
                        'start_date' => '2022-08-01',
                        'end_date' => '9999-12-31',
                    ])
                ]);
            }

        });
    }

}
