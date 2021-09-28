<?php

namespace App\Http\Controllers\Import;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\WorkshopCat;
use App\Models\WorkshopGroup;
use App\Models\WorkshopProduct;
use App\Models\WorkshopUnit;
use Box\Spout\Common\Type;
use Box\Spout\Reader\Common\Creator\ReaderFactory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EmployeeImportController extends Controller
{

    //todo 10月13日討論完再做
    public function import()
    {
        $reader = ReaderFactory::createFromType(Type::XLSX);

        $reader->open('imports\employee.xlsx');

        foreach ($reader->getSheetIterator() as $sheet) {

            $employeeArr = array();

            foreach ($sheet->getRowIterator() as $rowKey => $row) {
                // do stuff with the row
                if($rowKey == 1 || $rowKey == 2) continue;
                $rowValues = $row->toArray();

                //僱員數組
                $employeeArr[] = $rowValues;

            }
        }

        dump($employeeArr);

//         数据库事务处理
        DB::transaction(function() use($employeeArr){

            //插入產品
            $employeeModel = new Employee();

            foreach ($employeeArr as $employee){

                //插入,更新時間

//                0 => array:6 [▼
//                    0 => "R000001"
//                    1 => "盧弘發"
//                    2 => "營運經理"
//                    3 => DateTime @1482854400 {#1984 ▼
//                                    date: 2016-12-28 00:00:00.0 PRC (+08:00)
//                    }
//                    4 => "4年9月"
//                    5 => "糧控"
//                  ]

                //插入,更新時間
                $now = Carbon::now()->toDateTimeString();

                $employeeModel->insert([
                    'name' => $employee[1],
                    'code' => $employee[0],
                    'title' => $employee[2],
                    'claim_level' => 1,
                    'is_worked' => 1,
                    'employment_date' => $employee[3],
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);

            }

        });


        $reader->close();
    }

}
