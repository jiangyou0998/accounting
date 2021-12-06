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

class RepairItemImportController extends Controller
{
    public function importRepairItem()
    {
        $reader = ReaderFactory::createFromType(Type::XLSX);

        $filename = 'imports\repairitem new.xlsx';
        $reader->open($filename);

        $exportArr = [];

//        dd($changeUnitArr);

        $locationArr = [];
        $itemArr = [];
        $detailArr = [];
        $location_id = 1;
        $item_id = 1;
        $detail_id = 1;

        foreach ($reader->getSheetIterator() as $sheet) {

            foreach ($sheet->getRowIterator() as $rowKey => $row) {
                // do stuff with the row
                $rowValues = $row->toArray();

                if($rowValues[0]){
                    $locationArr[$location_id] = $rowValues[0];
                    $location_id ++;
                }

                if($rowValues[1]){
                    $itemArr[$item_id] = $rowValues[1];
                    $item_id ++;
                }

                if($rowValues[2]){
                    $detailArr[$detail_id] = $rowValues[2];
                    $detail_id ++;
                }

            }
        }

//        dump($locationArr);
//        dump($itemArr);
//        dd($detailArr);

        $this->importLocations($locationArr);
        $this->importItems($itemArr);
        $this->importDetails($detailArr);
//        $this->importSupplierProductItems($productArr);

        $reader->close();

        return 'success';
    }
//    public function importRepairItem()
//    {
//        $reader = ReaderFactory::createFromType(Type::XLSX);
//
//        $filename = 'imports\repairitem.xlsx';
//        $reader->open($filename);
//
//        $exportArr = [];
//
////        dd($changeUnitArr);
//
//        foreach ($reader->getSheetIterator() as $sheet) {
//
//            foreach ($sheet->getRowIterator() as $rowKey => $row) {
//                // do stuff with the row
//                if($rowKey == 1) continue;
//                $rowValues = $row->toArray();
//                $exportArr[$rowValues[0]][$rowValues[1]][$rowValues[2]] = 'xx';
//
//            }
//        }
//
//        $locationArr = [];
//        $itemArr = [];
//        $detailArr = [];
//        $location_id = 1;
//        $item_id = 1;
//        $detail_id = 1;
//        foreach ($exportArr as $location_name => $repairs) {
////            [1 => "VIP房"]
//            $locationArr[$location_id] = $location_name;
//            foreach ($repairs as $item_name => $details) {
//                $itemArr[$item_id][$location_id] = $item_name;
//                foreach ($details as $detail_name => $v) {
//                    $detailArr[$detail_id][$item_id] = $detail_name;
//                    $detail_id ++ ;
//                }
//                $item_id ++ ;
//            }
//            $location_id ++ ;
//        }
//
////        dump($locationArr);
////        dump($itemArr);
////        dd($detailArr);
////        dd($productArr);
////        dump($supplierArr);
//
//        $this->importLocations($locationArr);
//        $this->importItems($itemArr);
//        $this->importDetails($detailArr);
////        $this->importSupplierProductItems($productArr);
//
//        $reader->close();
//
//        return 'success';
//    }

    public function importLocations(array $data){
        DB::transaction(function() use($data){
            foreach ($data as $id => $name){
                DB::table('repair_locations')->insert([
                    'id' => $id,
                    'name' => $name,
                    'sort' => 100,
                ]);
            }
        });
    }

    public function importItems(array $data){
        DB::transaction(function() use($data){
            foreach ($data as $id => $name){
                DB::table('repair_items')->insert([
                    'id' => $id,
                    'name' => $name,
                    'sort' => 100,
                ]);
            }
        });
    }

    public function importDetails(array $data){
        DB::transaction(function() use($data){
            foreach ($data as $id => $name){
                DB::table('repair_details')->insert([
                    'id' => $id,
                    'name' => $name,
                    'sort' => 100,
                ]);
            }
        });
    }

}
