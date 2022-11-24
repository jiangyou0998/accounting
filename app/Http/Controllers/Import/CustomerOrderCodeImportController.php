<?php

namespace App\Http\Controllers\Import;


use App\Http\Controllers\Controller;
use App\Models\CustomerOrderCode;
use App\Models\ShopGroup;
use App\Models\WorkshopProduct;
use Box\Spout\Common\Type;
use Box\Spout\Reader\Common\Creator\ReaderFactory;
use Illuminate\Support\Facades\DB;

class CustomerOrderCodeImportController extends Controller
{
    public function import()
    {
        $reader = ReaderFactory::createFromType(Type::XLSX);

        $filename = 'imports\CustomerOrderCodeImport.xlsx';
        $reader->open($filename);

        $codeArr = [];

        foreach ($reader->getSheetIterator() as $sheet) {

            foreach ($sheet->getRowIterator() as $rowKey => $row) {
                // do stuff with the row
                if($rowKey == 1) continue;
                $rowValues = $row->toArray();

                $codeArr[] = $rowValues;

            }
        }

        DB::transaction(function() use($codeArr){

            $products = WorkshopProduct::all()->pluck('id', 'product_no')->toArray();

            foreach ($codeArr as $code){
                if($code[1] !== ''){
                    CustomerOrderCode::firstOrCreate(
                        array(
                            'shop_group_id' => ShopGroup::LAGARDERE_SHOP_ID,
                            'product_id' => $products[$code[0]],
                            'customer_order_code' => $code[1]
                        )
                    );
                }
            }
        });

        $reader->close();

        return 'success';
    }

}
