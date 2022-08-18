<?php

namespace App\Http\Controllers\Import;


use App\Http\Controllers\Controller;
use App\Models\CrmData;
use App\Models\WorkshopUnit;
use Box\Spout\Common\Type;
use Box\Spout\Reader\Common\Creator\ReaderFactory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CrmDataImportController extends Controller
{
    public function import()
    {
        $reader = ReaderFactory::createFromType(Type::CSV);

        $filename = 'imports\crmdata.csv';
        $reader->close();
        $reader->open($filename);

        foreach ($reader->getSheetIterator() as $sheet) {

            set_time_limit(0);
            ini_set('max_execution_time', 5000);
            $insertArr = array();

            foreach ($sheet->getRowIterator() as $rowKey => $row) {
                // do stuff with the row
                if($rowKey == 1) continue;
                $rowValues = $row->toArray();

                $headArr = [
                    //客戶編號
                    'id' => 0,
                    //客戶名稱
                    'name' => 1,
                    //會員級別
                    'level' => 5,
                    //性別
                    'sex' => 6,
                    //出生日期
                    'date_of_birth' => 7,
                    //移動電話
                    'mobile' => 8,
                    //電子郵箱
                    'email' => 10,
                    //最近一次光顧時間
                    'last_visit' => 15,
                    //創建日期
                    'create_date' => 16,
                    //到期時間
                    'expiry_date' => 19,
                    //積分
                    'point' => 20,
                    //總支出
//                    'total_spend' => 23,
                ];

                foreach ($headArr as $key => $line_no){

                    switch ($key)
                    {
                        case 'date_of_birth':
                            if($rowValues[$line_no] == ''){
                                $tempArr[$key] = null;
                            }else{
                                $tempArr[$key] = Carbon::parse($rowValues[$line_no])->toDateString();
                            }
                            break;

                        default:
                            $tempArr[$key] = $rowValues[$line_no] == '' ? null : $rowValues[$line_no];
                    }



                }

                $insertArr[] = $tempArr;
//                CrmData::insert($tempArr);

            }
        }


        $chunks = array_chunk($insertArr, 5000);

        foreach ($chunks as $chunk){
            CrmData::insert($chunk);
//            dump($chunk);
        }

//        DB::table('crm_datas')->insert($insertArr);

//        dd($productArr);
//        dd($supplierArr);

//        $this->importUnits($unitArr);
//        $this->importSuppliers($supplierArr);
//        $this->importGroups($groupArr);
//        $this->importWarehouseGroups($warehouseGroupArr);
//        $this->importSupplierProductItems($productArr);

        $reader->close();

//        return 'success';
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
