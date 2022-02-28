<?php

namespace App\Admin\Extensions;

use App\Common\Tools\excel\excelclass\ExcelExport;
use App\Models\SalesCalResult;
use App\User;
use Dcat\Admin\Grid\Exporters\AbstractExporter;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;


class ExcelExporter extends AbstractExporter
{
    // +-----------------------------------------------------
// | 使用easy-excel導出數據
// +-----------------------------------------------------
// | github: https://github.com/jqhph/easy-excel
// +-----------------------------------------------------
    public function export()
    {
        //你的数据查询
        $sales_cal_results = SalesCalResult::query()
            ->whereBetween('date', ['2022-02-01', '2022-02-28'])
            ->get()
            ->groupBy('shop_id')
            ->toArray();

        $headings = [
            'date' => '日期',
            'last_balance' => '承上結餘',
            'income_sum' => '收入',
            'difference' => '差額',
        ];

        $shop_pocodes = User::all()->pluck('pocode', 'id')->toArray();

        $folder = '/tmp';
        foreach ($sales_cal_results as $shop_id => $result){
            // 保存到当前服务器
            $filename = $shop_pocodes[$shop_id].'.xlsx';
            $file_path = $folder.'/'.$filename;
            \Dcat\EasyExcel\Excel::export($result)->store($file_path);
            // 使用 filesystem
            $adapter = new Local('tmp');

            $filesystem = new Filesystem($adapter);

            Excel::export($result)->headings($headings)->disk($filesystem)->store($filename);
        }

        //打包zip并下载
        $excelObj = new ExcelExport();
        $excelObj->fileload('測試文件');
    }
}
