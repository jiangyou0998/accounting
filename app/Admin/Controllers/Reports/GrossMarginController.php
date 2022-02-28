<?php

namespace App\Admin\Controllers\Reports;


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
use Dcat\EasyExcel\Excel;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;


class GrossMarginController extends AdminController
{

    public function index(Content $content)
    {
        return $content
            ->header('毛利率報告')
            ->body($this->grid());
    }

    protected function grid()
    {
        return Grid::make(null, function (Grid $grid) {

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

            $data = $this->generate();

            // 设置表格数据
            $grid->model()->setData($data);

            $grid->tools(function (Grid\Tools $tools){
                $previewUrl = route('export.gross_margin');
                $class = 'btn-primary';
                $download_button =  "<a href='{$previewUrl}' class='btn {$class} download' target='_blank'> &nbsp;&nbsp;&nbsp;<i class='fa fa-download'></i>&nbsp;全部下載&nbsp;&nbsp;&nbsp; </a>";
                $tools->append($download_button);
            });

//            $grid->export(new ExcelExport());

            $grid->filter(function (Grid\Filter $filter) {

                // 更改为 panel 布局
                $filter->panel();
                $filter->month('month', '報表日期');
                $filter->equal('group', '分組')->select(getReportShop());

            });

        });
    }

    private function generate()
    {
        $items = WorkshopCartItem::query()
            ->whereBetween('deli_date', ['2022-02-01', '2022-02-28'])
            ->where('workshop_cart_items.status', '<>', 4)
            ->where('user_id', 40)
            ->orderBy('deli_date')
            ->get();

        foreach ($items as $item){
            $item->real_qty = $item->qty_received ?? $item->qty;
            $item->total_price = $item->real_qty * $item->order_price;
        }

        $sale_datas = SalesCalResult::query()
            ->whereBetween('date', ['2022-02-01', '2022-02-28'])
            ->get();

        $month = '2022-02';
//        foreach ($items as $item){
//            $total[$item->deli_date]['營業額'] = 0;
//            $total[$item->deli_date]['購貨金額'] = 0;
//        }
        $start = Carbon::parse($month)->startOfMonth();
        $last = Carbon::parse($month)->lastOfMonth();
        $day = $start;
        while ($day->lte($last)){
            $date = $day->toDateString();
            $total[$date]['營業額'] = 0;
            $total[$date]['購貨金額'] = 0;
            $day->addDay(1);
        }

        foreach ($items as $item){
            $total[$item->deli_date]['購貨金額'] += $item->total_price;
        }

        foreach ($sale_datas as $sale_data){
            $total[$sale_data->date]['營業額'] += $sale_data->income_sum;
        }

        $cats = WorkshopCat::getCats();
        $resales = WorkshopGroup::getResaleGroups();
        $groupIdAndCatId = WorkshopGroup::all()->pluck('cat_id','id')->toArray();
        $productIdAndGroupId = WorkshopProduct::query()
            ->with(['groups', 'cats'])
            ->get()
            ->groupBy('id')
            ->toArray();

//        dump($items->toArray()[0]);
//        dump($sale_datas->toArray());
//        dump($total);
//        dump($groupIdAndCatId);
//        dump($productIdAndGroupId);

    }

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
            Excel::export($result)->store($file_path);
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
