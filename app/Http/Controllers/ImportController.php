<?php

namespace App\Http\Controllers;
use Box\Spout\Common\Type;
use Box\Spout\Reader\Common\Creator\ReaderFactory;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ImportController extends Controller
{

    //todo 10月13日討論完再做
    public function import()
    {
        $reader = ReaderFactory::createFromType(Type::XLSX);

        $reader->open('import.xlsx');

        $arr = array();

        foreach ($reader->getSheetIterator() as $sheet) {
//            dump($sheet);
            foreach ($sheet->getRowIterator() as $rowKey => $row) {
                // do stuff with the row
                if ($rowKey > 3) {
                    $cells = $row->getCells();

                    $sheetName = $sheet->getName();
                    $startTime = new Collection();
                    $endTime = new Collection();
                    $cellName = $cells[0]->getValue();
                    foreach ($cells as $cellKey => $cell) {
                        if ($cellKey > 0) {


                            $time = $cell->getValue();

                            $startTime->add($this->getStartTime($time));
                            $endTime->add($this->getEndTime($time));

                            $arr[$sheetName][$cellName][] = $cell->getValue();

                        }
                    }

                    $arr[$sheetName][$cellName]['start'] = $startTime->min();
                    $arr[$sheetName][$cellName]['end'] = $endTime->max();


                }


            }
        }

        dump($arr['盧弘發']);

        $reader->close();
    }

    //上班時間
    private function getStartTime($time,$overTime = 10)
    {
        if($time != ""){
            $dt = Carbon::parse($time);

            if($dt->minute < $overTime){
                //未超過一定時間,分鐘歸零
                $dt->minute = 0;
            }else if($dt->minute < 30+$overTime){
                $dt->minute = 30;
            }else{
                $dt->hour += 1;
                $dt->minute = 0;
            }

            return $dt->isoFormat('HH:mm');

        }
    }

    //下班時間
    private function getEndTime($time)
    {
        if($time != ""){
            $dt = Carbon::parse($time);

            if($dt->minute > 0 && $dt->minute < 30){
                $dt->minute = 0;

            }else{
                $dt->minute = 30;
            }


            return $dt->isoFormat('HH:mm');

        }
    }


}
