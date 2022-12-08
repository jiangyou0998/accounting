<?php

namespace App\Admin\Controllers\Reports;


use App\Admin\Forms\GrossMarginExport;
use App\Common\Tools\excel\excelclass\ExcelExport;
use App\Models\SalesCalResult;
use App\Models\WorkshopCartItem;
use App\Models\WorkshopCat;
use App\Models\WorkshopGroup;
use App\Models\WorkshopProduct;
use App\User;
use Carbon\Carbon;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Widgets\Modal;
use Dcat\EasyExcel\Excel;
use Illuminate\Http\Request;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;


class GrossMarginController extends AdminController
{

    public function index(Content $content)
    {
        $month = request('month') ?? Carbon::now()->subMonth()->isoFormat('YYYY-MM');
        $ids = explode('-', request('shop') ?? '');

        $indexPage = $content
            ->header('毛利率報告')
            ->body($this->render());

        //有選擇分店才查詢
        if(request('shop')){
            $datas = $this->getData($month, $ids);

            foreach ($datas as $data){
                $indexPage = $indexPage->body($this->grid($data));
            }
        }

        return $indexPage;
    }

    protected function grid($data)
    {
        return Grid::make(null, function (Grid $grid) use($data){

            $grid->withBorder();
            $data = array_values($data);
//            dump($data);
            //禁用 导出所有 选项
//            $grid->export()->disableExportAll();
            //禁用 导出选中行 选项
//            $grid->export()->disableExportSelectedRow();
            // 禁用行选择器
            $grid->disableRowSelector();
            $grid->disableCreateButton();
            $grid->disableActions();
            $grid->disableBatchDelete();
            $grid->disablePagination();

            // 设置表格数据
            $grid->model()->setData($data);

            $headings = array_keys(current($data));

            foreach ($headings as $value){
                $grid->column($value);
            }

//            $grid->tools(function (Grid\Tools $tools){
//                $previewUrl = route('admin.export.gross_margin');
//                $class = 'btn-primary';
//                $download_button =  "<a href='{$previewUrl}' class='btn {$class} download' target='_blank'> &nbsp;&nbsp;&nbsp;<i class='fa fa-download'></i>&nbsp;全部下載&nbsp;&nbsp;&nbsp; </a>";
//                $tools->append($download_button);
//            });
//
////            $grid->export(new ExcelExport());
//
//            $grid->filter(function (Grid\Filter $filter) {
//
//                // 更改为 panel 布局
//                $filter->panel();
//                $filter->month('month', '報表日期');
//                $filter->equal('group', '分組')->select(getReportShop());
//
//            });

        });
    }

    private function getData($month, $ids)
    {
        $start_date_carbon = Carbon::parse($month)->firstOfMonth();
        $start_date = Carbon::parse($month)->firstOfMonth()->toDateString();
        $end_date_carbon = Carbon::parse($month)->endOfMonth();
        $end_date = Carbon::parse($month)->endOfMonth()->toDateString();

        //你的数据查询
        $cats = WorkshopCat::getCatsExceptResale();
        $resales = WorkshopGroup::getResaleGroups();
        $product_cat_ids = WorkshopProduct::getProductCatIds();
        $product_group_ids = WorkshopProduct::getProductGroupIds();

        $items = WorkshopCartItem::query()
            ->whereBetween('deli_date', [$start_date, $end_date])
            ->whereIn('user_id', $ids)
            ->where('status', '!=', 4)
            ->get(['user_id', 'product_id', 'deli_date', 'qty', 'qty_received', 'order_price']);


        $results = [];
        $time = $start_date_carbon;

        $income_sums = SalesCalResult::query()
            ->whereBetween('date', [$start_date, $end_date])
            ->whereIn('shop_id', $ids)
            ->get(['shop_id', 'date', 'income_sum'])
            ->groupBy(['shop_id', 'date'])
            ->toArray();

        $shop_names = User::whereNotNull('report_name')
            ->get()
            ->pluck('report_name', 'id')
            ->toArray();

        while($end_date_carbon->gte($time)) {
            $time_string = $time->toDateString();

            foreach ($ids as $shop_id){

                $results[$shop_id][$time_string]['分店'] = $shop_names[$shop_id] ?? '';
                $results[$shop_id][$time_string]['日期'] = $time_string;

                //營業額
                $results[$shop_id][$time_string]['營業額'] = $income_sums[$shop_id][$time_string][0]['income_sum'] ?? 0;

                //按分類
                foreach ($cats as $cat){
                    $results[$shop_id][$time_string][$cat->cat_name] = 0;
                }

                //按轉手貨部門
                foreach ($resales as $resale){
                    $results[$shop_id][$time_string][$resale->group_name] = 0;
                }

                $results[$shop_id][$time_string]['total'] = 0;

                $results[$shop_id][$time_string]['毛利率'] = '';

            }

            $time = $time->addDay();
        }

        $cat_ids = $cats->pluck('cat_name', 'id')->toArray();
        $resale_ids = $resales->pluck('group_name', 'id')->toArray();

        foreach ($items as $item){
            $qty =  $item->qty_received ?? $item->qty;
            $sum = $qty * ($item->order_price);
            $product_id = $item->product_id;
            $cat_id = $product_cat_ids[$product_id] ?? 0;
            $group_id = $product_group_ids[$product_id] ?? 0;

            if (array_key_exists($cat_id, $cat_ids)){
                $results[$item->user_id][$item->deli_date][$cat_ids[$cat_id]] += $sum;
                $results[$item->user_id][$item->deli_date]['total'] += $sum;
            }

            if (array_key_exists($group_id, $resale_ids)){
                $results[$item->user_id][$item->deli_date][$resale_ids[$group_id]] += $sum;
                $results[$item->user_id][$item->deli_date]['total'] += $sum;
            }

            $income_sum = $results[$item->user_id][$item->deli_date]['營業額'];
            $total = $results[$item->user_id][$item->deli_date]['total'];

            //計算毛利率
            if($income_sum > $total){
                $results[$item->user_id][$item->deli_date]['毛利率'] = round(($income_sum - $total) / $income_sum * 100 , 2) . '%';
            }

        }

        return $results;
    }

// +-----------------------------------------------------
// | 使用easy-excel導出數據
// +-----------------------------------------------------
// | github: https://github.com/jqhph/easy-excel
// +-----------------------------------------------------
    public function export(Request $request)
    {
        $month = $request->month ?? Carbon::now()->subMonth()->isoFormat('YYYY-MM');
        $ids = explode('-', $request->shop ?? '');

        $results = $this->getData($month, $ids);

        $shop_pocodes = User::all()->pluck('pocode', 'id')->toArray();

        //文件保存路徑
        $folder = '/tmp';

        //生成所有Excel文件
        foreach ($results as $shop_id => $result){
            // 保存到当前服务器
            $filename = ($shop_pocodes[$shop_id] ?? 'NOCODE').'.xlsx';
            $file_path = $folder.'/'.$filename;
//            Excel::export($result)->store($file_path);
            // 使用 filesystem
            $adapter = new Local('tmp');

            $filesystem = new Filesystem($adapter);

//            $headings = array_keys(current($result));
//
//            dd($result);
            Excel::export(array_values($result))->disk($filesystem)->store($filename);
        }

        $zipname = 'Gross Margin Report ' . $month;

        //打包zip并下载
        $excelObj = new ExcelExport();
        $excelObj->fileload($zipname);
    }

    //批量導出Excel
    protected function batchExport()
    {
        return Modal::make()
            ->lg()
            ->title('毛利率數據導出')
            ->body(GrossMarginExport::make())
            ->button('<button class="btn btn-primary"><i class="feather icon-download"></i>&nbsp;全部下載</button>');
    }

    //生成頂部按鈕
    protected function render()
    {
        return <<<HTML
{$this->batchExport()}
<br><br>
HTML;
    }

}
