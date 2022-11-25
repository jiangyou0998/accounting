<?php

use App\Models\CrmData;
use Box\Spout\Common\Type;
use Box\Spout\Reader\Common\Creator\ReaderFactory;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CrmDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $reader = ReaderFactory::createFromType(Type::CSV);

        $filename = public_path('imports\crmdata.csv');
        $reader->close();
        $reader->open($filename);

        foreach ($reader->getSheetIterator() as $sheet) {

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

                        case 'point':
                            $tempArr[$key] = $rowValues[$line_no] == '' ? 0 : $rowValues[$line_no];
                            break;

                        default:
                            $tempArr[$key] = $rowValues[$line_no] == '' ? null : $rowValues[$line_no];
                    }

                }

                $insertArr[] = $tempArr;

            }
        }


        $chunks = array_chunk($insertArr, 1000);

        foreach ($chunks as $chunk){
            CrmData::insert($chunk);
        }

        $reader->close();
    }
}
