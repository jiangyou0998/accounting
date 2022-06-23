<?php

namespace App\Admin\Controllers\Reports;


use App\Models\SalesCalResult;
use App\Models\SalesIncomeType;
use App\User;
use Carbon\Carbon;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Widgets\Card;


//貨倉入貨報告
class SalesDataByShopReportController extends AdminController
{
    public function index(Content $content)
    {
        return $content
            ->header('分店三更數報告')
            ->body($this->grid());
    }

    protected function grid()
    {
        return Grid::make(null, function (Grid $grid) {

            $grid->header(function ($collection) {

                $month = getMonth();

                // 标题和内容
                $cardInfo = <<<HTML
        <h1>月份:<span style="color: red">$month</span></h1>
HTML;
                $card = Card::make('', $cardInfo);

                return $card;
            });

            $month = getMonth();

            $data = $this->generate($month);

            $titles = array_keys(current($data));

            foreach ($titles as $value){
                $grid->column($value);
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
                $filter->month('month', '報表日期');

            });

            $filename = '分店三更數報告 ' . $month;
            $grid->export()->csv()->filename($filename);

        });

    }

    /**
     * 生成数据
     *
     * @return array
     */
    private function generate($month)
    {
        $start_date = Carbon::parse($month)->firstOfMonth()->toDateString();
        $end_date = Carbon::parse($month)->endOfMonth()->toDateString();

        $shop = User::getKingBakeryShops();
//        $shops = array_column($shop, 'report_name', 'id');
        $ids = $shop->pluck('id');

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
//                $result->date = Carbon::parse($result->date)->isoFormat('YYYY/MM/DD') ?? '';
                $result->date = Carbon::parse($result->date)->toDateString() ?? '';

                foreach ($sales_income_types as $type_no => $name){
                    $result->{$name} = $result->details->where('type_no', $type_no)->first()->income ?? '' ;
                }

                return $result;
            });

        $result = array();
        foreach ($sales_cal_results as $sales_cal_result){
            $result[$sales_cal_result->shop_id][$sales_cal_result->date] = $sales_cal_result->toArray();
        }

        $data = array();
        $loop_start_date = Carbon::parse($month)->firstOfMonth();
        $loop_end_date = Carbon::parse($month)->endOfMonth();

        while ($loop_start_date < $loop_end_date) {
            $date_column_name = '日期';
            $data[$loop_start_date->day.'_1'][$date_column_name] = $loop_start_date->toDateString();
            $data[$loop_start_date->day.'_2'][$date_column_name] = '';
            $data[$loop_start_date->day.'_3'][$date_column_name] = '';
            $data[$loop_start_date->day.'_4'][$date_column_name] = '';
            $data[$loop_start_date->day.'_5'][$date_column_name] = '';
            $data[$loop_start_date->day.'_6'][$date_column_name] = '';
            $data[$loop_start_date->day.'_7'][$date_column_name] = '';
            $data[$loop_start_date->day.'_8'][$date_column_name] = '';

            $type_column_name = '收/存';
            $data[$loop_start_date->day.'_1'][$type_column_name] = '營業額';
            $data[$loop_start_date->day.'_2'][$type_column_name] = '到會收入';
            $data[$loop_start_date->day.'_3'][$type_column_name] = '其他收入';
            $data[$loop_start_date->day.'_4'][$type_column_name] = '總收入';
            $data[$loop_start_date->day.'_5'][$type_column_name] = '存';
            $data[$loop_start_date->day.'_6'][$type_column_name] = '八達通';
            $data[$loop_start_date->day.'_7'][$type_column_name] = '支付寶';
            $data[$loop_start_date->day.'_8'][$type_column_name] = '微信';

            foreach ($shop_names as $shop_id => $shop_name) {
                $date_string = $loop_start_date->toDateString();

                $octopus_income = $result[$shop_id][$date_string]['octopus_income'] ?? 0;
                $alipay_income = $result[$shop_id][$date_string]['alipay_income'] ?? 0;
                $wechatpay_income = $result[$shop_id][$date_string]['wechatpay_income'] ?? 0;
                $deposit = (float)$octopus_income + (float)$alipay_income + (float)$wechatpay_income;

                $data[$loop_start_date->day.'_1'][$shop_name] = $result[$shop_id][$date_string]['income_sum'] ?? '';
                $data[$loop_start_date->day.'_2'][$shop_name] = '';
                $data[$loop_start_date->day.'_3'][$shop_name] = '';
                $data[$loop_start_date->day.'_4'][$shop_name] = $result[$shop_id][$date_string]['income_sum'] ?? '';
                $data[$loop_start_date->day.'_5'][$shop_name] = ($deposit != 0) ? $deposit : '';
                $data[$loop_start_date->day.'_6'][$shop_name] = ($octopus_income != 0) ? $octopus_income : '';
                $data[$loop_start_date->day.'_7'][$shop_name] = ($alipay_income != 0) ? $alipay_income : '';
                $data[$loop_start_date->day.'_8'][$shop_name] = ($wechatpay_income != 0) ? $wechatpay_income : '';

            }
            $loop_start_date->addDay();
        }

        return array_values($data);
    }

}
