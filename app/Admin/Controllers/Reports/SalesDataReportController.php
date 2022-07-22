<?php

namespace App\Admin\Controllers\Reports;


use App\Admin\Forms\SalesDataExport;
use App\Admin\Forms\SalesDataTableShow;
use App\Admin\Renderable\ThisShopTable;
use App\Common\Tools\excel\excelclass\ExcelExport;
use App\Http\Traits\SalesDataTableTraits;
use App\Models\SalesCalResult;
use App\Models\SalesIncomeType;
use App\Models\ShopGroup;
use App\User;
use Carbon\Carbon;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Widgets\Card;
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
            ->body($this->render())
            ->body($this->grid());
    }

    protected function grid()
    {
        return Grid::make(null, function (Grid $grid) {

            $start = getStartTime();
            $end = getEndTime();
            //選中的商店id
            $shop_id = isset($_REQUEST['shop_id']) ? $_REQUEST['shop_id'] : null;

            $data = $this->generate($start, $end, $shop_id);

            $grid->header(function ($collection) use($start, $end){

                // 标题和内容
                $cardInfo = <<<HTML
        <h1>日期:<span style="color: red">{$start} 至 {$end}</span></h1>
HTML;
                $card = Card::make('', $cardInfo);

                return $card;
            });

            $headings = [
                'shop_name' => '分店',
                'date' => '日期',
                'income_sum' => '收入',
                'morning_income' => '早市收入',
                'noon_income' => '午市收入',
                'afternoon_tea_income' => '下午茶收入',
                'evening_income' => '晚市收入',
                'night_snack_income' => '宵夜收入',
                'bread_income' => '麵包營業額',
                'octopus_income' => '八達通',
                'alipay_income' => '支付寶',
                'wechatpay_income' => '微信',
                'foodpanda_income' => 'Foodpanda',
                'last_balance' => '上日餘數',
                'escort_cash' => '今日押運上期',
                'balance' => '餘數',
                'difference' => '差額',
            ];

            if($data){
                foreach ($headings as $name => $label){
                    $grid->column($name, $label);
                }
//                $grid->fixColumns(2, 0);
            }

            $grid->withBorder();

            //禁用 导出所有 选项
            $grid->export()->disableExportAll();
            //禁用 导出选中行 选项
            $grid->export()->disableExportSelectedRow();
            // 禁用行选择器
            $grid->disableRowSelector();
            $grid->disableCreateButton();
            $grid->disableActions();
            $grid->disableBatchDelete();
            $grid->disablePagination();

            // 设置表格数据
            $grid->model()->setData($data);

            $grid->filter(function (Grid\Filter $filter) {

                // 更改为 panel 布局
                $filter->panel();

                $last_month = Carbon::now()->subMonth();
                $filter->between('between', '報表日期')->date();

                $filter->equal('shop_id', '分店')
                    ->multipleSelectTable(ThisShopTable::make()) // 设置渲染类实例，并传递自定义参数
                    ->title('弹窗标题')
                    ->dialogWidth('50%') // 弹窗宽度，默认 800px
                    ->model(User::class, 'id', 'txt_name'); // 设置编辑数据显示

            });

            $filename = '營業數報告 ' . $start . '至' . $end;
            $grid->export()->titles($headings)->csv()->filename($filename);

        });

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

                //2022-04-07 修改日期顯示格式
                $result->date = Carbon::parse($result->date)->isoFormat('YYYY/MM/DD') ?? '';

                foreach ($sales_income_types as $type_no => $name){
                    $result->{$name} = $result->details->where('type_no', $type_no)->first()->income ?? '' ;
                }

                return $result;
            })
            ->groupBy('shop_id')
            ->toArray();

        $headings = [
            'date' => '日期',
            'last_balance' => '上日餘數',
            'first_pos_no' => '主機編號',
            'first_pos_income' => '主機收入',
            'second_pos_no' => '副機編號',
            'second_pos_income' => '副機收入',
            'morning_income' => '早市收入',
            'noon_income' => '午市收入',
            'afternoon_tea_income' => '下午茶收入',
            'evening_income' => '晚市收入',
            'night_snack_income' => '宵夜收入',
            'bread_income' => '麵包營業額',
            'octopus_income' => '八達通',
            'alipay_income' => '支付寶',
            'wechatpay_income' => '微信',
            'foodpanda_income' => 'Foodpanda',
            'difference' => '差額',
        ];

        $shop_pocodes = User::all()->pluck('pocode', 'id')->toArray();

        //文件保存路徑
        $folder = '/tmp';

        //生成所有Excel文件
        foreach ($sales_cal_results as $shop_id => $result){
            // 保存到当前服务器
            $filename = ($shop_pocodes[$shop_id] ?? 'NOCODE').'.csv';
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

    private function generate($start, $end, $shop_id = null)
    {
        $start_date = Carbon::parse($start)->toDateString();
        $end_date = Carbon::parse($end)->toDateString();

        if(is_null($shop_id) || $shop_id === ''){
            $shop = User::getShopsByShopGroup(ShopGroup::CURRENT_SHOP_ID);
            $ids = $shop->pluck('id');
        }else{
            $ids = explode(',', $shop_id);
            $shop = User::query()->whereIn('id', $ids)->get(['id','report_name']);
        }

        $shop_names = $shop->pluck('report_name', 'id')->toArray();

        //你的数据查询
        $sales_income_types = SalesIncomeType::all()->pluck('name','type_no');

        $sales_cal_results = SalesCalResult::query()
            ->with('details')
            ->whereBetween('date', [$start_date, $end_date])
            ->whereIn('shop_id', $ids)
            ->orderBy('shop_id')
            ->get()
            ->map(function (SalesCalResult $result) use($sales_income_types, $shop_names){

                $result->shop_name = $shop_names[$result->shop_id] ?? '';
                //2022-04-07 修改日期顯示格式
                $result->date = Carbon::parse($result->date)->isoFormat('YYYY/MM/DD') ?? '';

                foreach ($sales_income_types as $type_no => $name){
                    $result->{$name} = $result->details->where('type_no', $type_no)->first()->income ?? '' ;
                }

                return $result;
            });

//        dump($sales_cal_results->toArray());

        return $sales_cal_results;
    }

}
