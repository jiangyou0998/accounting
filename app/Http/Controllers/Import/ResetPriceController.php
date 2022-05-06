<?php

namespace App\Http\Controllers\Import;
use App\Http\Controllers\Controller;
use App\Models\Price;
use App\Models\Supplier\Supplier;
use App\Models\Supplier\SupplierProduct;
use App\Models\SupplierGroup;
use App\Models\WorkshopUnit;
use Box\Spout\Common\Type;
use Box\Spout\Reader\Common\Creator\ReaderFactory;
use Illuminate\Support\Facades\DB;

class ResetPriceController extends Controller
{
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
