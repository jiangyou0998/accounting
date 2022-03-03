<?php

namespace App\Admin\Controllers\Reports;


use App\Admin\Forms\SalesDataExport;
use App\Admin\Forms\SalesDataTableShow;
use App\Common\Tools\excel\excelclass\ExcelExport;
use App\Http\Traits\SalesDataTableTraits;
use App\Models\SalesCalResult;
use App\Models\SalesIncomeType;
use App\User;
use Carbon\Carbon;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Widgets\Modal;
use Dcat\EasyExcel\Excel;
use Illuminate\Http\Request;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;


class SalesDataReportController extends AdminController
{
    use SalesDataTableTraits;

    public function index(Content $content)
    {
        return $content
            ->header('營業數報告')
            ->description('營業數報告')
            ->body($this->render());
    }

// +-----------------------------------------------------
// | 使用easy-excel導出數據
// +-----------------------------------------------------
// | github: https://github.com/jqhph/easy-excel
// +-----------------------------------------------------
    public function export(Request $request)
    {
        $month = $request->month ?? Carbon::now()->subMonth()->isoFormat('YYYY-MM');
        $start_date = Carbon::parse($month)->firstOfMonth()->toDateString();
        $end_date = Carbon::parse($month)->endOfMonth()->toDateString();
        $ids = explode('-', $request->shop ?? '');

        //你的数据查询
        $sales_income_types = SalesIncomeType::all()->pluck('name','type_no');

        $sales_cal_results = SalesCalResult::query()
            ->with('details')
            ->whereBetween('date', [$start_date, $end_date])
            ->whereIn('shop_id', $ids)
            ->get()
            ->map(function (SalesCalResult $result) use($sales_income_types){

                foreach ($sales_income_types as $type_no => $name){
                    $result->{$name} = $result->details->where('type_no', $type_no)->first()->income ?? '' ;
                }

                return $result;
            })
            ->groupBy('shop_id')
            ->toArray();

        $headings = [
            'date' => '日期',
            'last_balance' => '承上結餘',
            'first_pos_no' => '主機編號',
            'first_pos_income' => '主機收入',
            'second_pos_no' => '副機編號',
            'second_pos_income' => '副機收入',
            'morning_income' => '早更收入',
            'afternoon_income' => '午更收入',
            'evening_income' => '晚更收入',
            'octopus_income' => '八達通',
            'alipay_income' => '支付寶',
            'wechatpay_income' => '微信',
            'pos_paper_money' => '收銀機紙幣',
            'pos_coin' => '收銀機硬幣',
            'safe_paper_money' => '夾萬紙幣',
            'safe_coin' => '夾萬硬幣',
            'deposit_in_safe' => '存入夾萬',
            'deposit_in_bank' => '存入銀行',
            'kelly_out' => '慧霖取銀',
            'bill_paid_sum' => '支單支出',
            'income_sum' => '收入',
            'difference' => '差額',
        ];

        $shop_pocodes = User::all()->pluck('pocode', 'id')->toArray();

        //文件保存路徑
        $folder = '/tmp';

        //生成所有Excel文件
        foreach ($sales_cal_results as $shop_id => $result){
            // 保存到当前服务器
            $filename = ($shop_pocodes[$shop_id] ?? 'NOCODE').'.xlsx';
            $file_path = $folder.'/'.$filename;
            Excel::export($result)->store($file_path);
            // 使用 filesystem
            $adapter = new Local('tmp');

            $filesystem = new Filesystem($adapter);

            Excel::export($result)->headings($headings)->disk($filesystem)->store($filename);
        }

        $zipname = 'Sales Data Report ' . $month;

        //打包zip并下载
        $excelObj = new ExcelExport();
        $excelObj->fileload($zipname);
    }

    //打印用表格(後台查看)
    public function print(Request $request){

        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $ids = explode('-', $request->shop ?? '');

        $all_sales_table_data = $this->getAllSalesTableData($start_date, $end_date, $ids);

        if(count($all_sales_table_data) === 0){
            return '<h1>當前搜索範圍未找到數據!</h1>';
        }
        return view('sales_data.print', compact('all_sales_table_data'));
    }

    // 普通非异步弹窗
    // 批量顯示每日營業數
    protected function batchShow()
    {
        return Modal::make()
            ->lg()
            ->title('每日營業數查詢')
            ->body(SalesDataTableShow::make())
            ->button('<button class="btn btn-success"><i class="feather icon-grid"></i>&nbsp;營業數查詢</button>');
    }

    //批量導出Excel
    protected function batchExport()
    {
        return Modal::make()
            ->lg()
            ->title('銷售數據導出')
            ->body(SalesDataExport::make())
            ->button('<button class="btn btn-primary"><i class="feather icon-download"></i>&nbsp;全部下載</button>');
    }

    //生成頂部按鈕
    protected function render()
    {
        return <<<HTML
{$this->batchShow()}
{$this->batchExport()}
<br><br>
HTML;
    }

}
