<?php

namespace App\Admin\Controllers\Claims;

use App\Admin\Renderable\RBShopTable;
use App\Admin\Renderable\ProductTable;
use App\Models\Claim;
use App\Models\ClaimLevel;
use App\Models\WorkshopCartItem;
use App\Models\WorkshopProduct;
use App\User;
use Carbon\Carbon;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Widgets\Card;
use Illuminate\Support\Facades\DB;


//分店銷售查詢
class ClaimReportController extends AdminController
{
    protected $status = [ -1 => '全部', 0 => '申請中', 1 => '已批核', 2 => '不理賠'];

    public function index(Content $content)
    {
        return $content
            ->header('醫療索償報表')
            ->body($this->grid());
    }

    protected function grid()
    {
        return Grid::make(null, function (Grid $grid) {

            $grid->withBorder();
            $start = getStartTimeOfYear();
            $end = getEndTimeOfYear();

            $claim_level_id = request()->claim_level_id ?? [];
            $status = request()->status ?? 1;

            $data = $this->generate($start, $end, $claim_level_id, $status);

            $grid->header(function ($collection){

                $start = getStartTimeOfYear();
                $end = getEndTimeOfYear();

                // 标题和内容
                $cardInfo = <<<HTML
        <h1>日期:<span style="color: red">{$start} 至 {$end}</span></h1>
HTML;
                $card = Card::make('', $cardInfo);

                return $card;
            });

            $claim_levels = ClaimLevel::all()->pluck('type_name', 'id');
            if (count($data) > 0) {
                $grid->column('employee.code', '員工編號');
                $grid->column('employee.name', '員工姓名(不是必須)');
                $grid->column('shop', '分店/部門');
                $grid->column('code', '津貼及扣糧編號');

                foreach ($claim_levels as $id => $type_name){
                    $grid->column('level'.$id, $type_name)->display(function () use($id){
                        if($this->claim_level_id == $id) return 1;
                    });
                }
                $grid->column('claim_date', '診症日(DD/MM/YYYY)');
                $grid->column('illness.item_name', '病症名稱');
                $grid->column('currency', '貨幣');
                $grid->column('cost', '索償金額');
                $grid->column('claim_cost', '應得賠償金額');
                $grid->column('upload', '上載文件/圖片');
                $grid->column('remark', '備註');
                $grid->column('status', '申請狀態(HR專用)')
                    ->using($this->status)
                    ->dot(
                        [
                            0 => 'warning',
                            1 => 'success',
                            2 => 'danger',
                        ],
                        'success' // 默认颜色
                    );
            }

            //匯出CSV
//            $titles = [
//                'employee_code' => '員工編號',
//                'employee_name' => '員工姓名(不是必須)',
//                'shop' => '分店/部門',
//                'code' => '津貼及扣糧編號' ,
//                'claim_date' => '診症日(DD/MM/YYYY)' ,
//                'illness_name' => '病症名稱' ,
//                'currency' => '貨幣' ,
//                'cost' => '索償金額' ,
//                'claim_cost' => '應得賠償金額' ,
//                'upload' => '上載文件/圖片' ,
//                'remark' => '備註' ,
//                'status' => '申請狀態(HR專用)' ,
//            ];

            $filename = '醫療索償 ' . $start . '至' . $end;

            $grid->export()->rows(function (array $rows) use($claim_levels){
                $exports = [];
                foreach ($rows as $index => &$row) {
                    $exports[$index]['員工編號'] = $row['employee']['code'];
                    $exports[$index]['員工姓名(不是必須)'] = $row['employee']['name'];
                    $exports[$index]['分店/部門'] = '';
                    $exports[$index]['津貼及扣糧編號'] = $row['code'];

                    foreach ($claim_levels as $id => $type_name){
                        if($row['claim_level_id'] == $id){
                            $exports[$index][$type_name] = 1;
                        }else{
                            $exports[$index][$type_name] = '';
                        }
                    }

                    $exports[$index]['診症日(DD/MM/YYYY)'] = $row['claim_date'];
                    $exports[$index]['病症名稱'] = $row['illness']['item_name'];
                    $exports[$index]['貨幣'] = $row['currency'];
                    $exports[$index]['索償金額'] = $row['cost'];
                    $exports[$index]['應得賠償金額'] = $row['claim_cost'];
                    $exports[$index]['上載文件/圖片'] = '';
                    $exports[$index]['備註'] = $row['remark'];
                    $exports[$index]['申請狀態(HR專用)'] = $this->status[$row['status']];
                }

                return $exports;
            })->csv()->filename($filename);

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

                $filter->between('between', '診症日')->date();
                $filter->equal('status', '申請狀態')->select($this->status)->default(1);

                $claim_levels = ClaimLevel::getClaimLevels();
                $filter->in('claim_level_id', '索償類型(可多選)')->multipleSelect($claim_levels);

            });

        });

    }

    /**
     * 生成数据
     *
     * @return array
     */
    public function generate($start, $end, $claim_level_ids = [], $status = -1)
    {
        $claims = Claim::with(['employee', 'illness'])
            ->whereBetween('claim_date', [$start, $end])
            ->ofClaimLevel($claim_level_ids)
            ->ofStatus($status)
            ->orderBy('employee_id')
            ->orderBy('claim_date')
            ->get();

        foreach ($claims as $claim){
            //津貼及扣糧編號
            $claim->code = 'ME';
            //貨幣
            $claim->currency = 'HKD';
            $claim->claim_date = Carbon::parse($claim->claim_date)->isoFormat('DD/MM/YYYY');
        }

//        dump($claims->toArray());
        return $claims;

    }

}
