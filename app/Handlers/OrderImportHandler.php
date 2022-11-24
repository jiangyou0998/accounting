<?php

namespace App\Handlers;


use Dcat\EasyExcel\Excel;

class OrderImportHandler
{

    public function excel_to_array($file){

        $allSheets = Excel::import($file)->first()->toArray();

        return $allSheets;
    }
}
