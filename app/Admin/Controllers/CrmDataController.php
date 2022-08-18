<?php

namespace App\Admin\Controllers;

use App\Models\CrmData;
use Carbon\Carbon;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;

class CrmDataController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new CrmData(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('name');
            $grid->column('level');
            $grid->column('sex');
            $grid->column('date_of_birth');
            $grid->column('mobile');
            $grid->column('email');
            $grid->column('last_visit');
            $grid->column('create_date');
            $grid->column('expiry_date');
            $grid->column('point');

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');

            });

            $titles = [
                'code' => '地區號碼',
                'mobile' => '會員電話*',
                'name' => '姓名',
                'level' => '等級',
                'point' => '現有積分',
                'point_level' => '現等級累積積分',
                'point_history' => '歷史總積分',
                'email' => '電郵',
                'sex' => '姓別 (M/F)',
                'date_of_birth' => '生日日期 (MMDD / MDD)',
                'age' => '年齡',
                'shop' => '啟動店舖',
                'create_date' => '成為會員日期',
                'expiry_date' => '有效日期',
                'app' => '已安裝App (已安裝/未安裝)',
                'terms' => '同意會員條款 (同意/不同意)',
                'promote' => '同意接受推廣訊息 (同意/不同意)',
                'remark' => '備註',
                'id' => '客戶編號'
            ];

            $grid->export($titles)->rows(function (array $rows) {
                foreach ($rows as $index => &$row) {

                    //21年7月8日前數據都為測試數據
                    if ($row['create_date'] < '2021-07-08'){
                        unset($rows[$index]);
                        continue;
                    }

                    if (strpos(strtolower($row['name']), 'test') !== false
                        || strpos(strtolower($row['name']), 'bindo') !== false
                        || strpos(strtolower($row['name']), 'kingbakery') !== false
                        || strpos(strtolower($row['name']), 'ryoyu') !== false
                        || strpos(strtolower($row['email']), 'test') !== false
                        || strpos(strtolower($row['email']), 'bindo') !== false
                        || strpos(strtolower($row['email']), 'kingbakery') !== false
                        || strpos(strtolower($row['email']), 'ryoyu') !== false
                    ) {
                        unset($rows[$index]);
                        continue;
                    }

                    //地區號碼
                    $row['code'] = '852';

                    //會員電話 - 去掉+852
                    $row['mobile'] = preg_replace('/\+852\s/', '', $row['mobile']);

                    //電話號碼沒有填寫的 刪除改數據
                    if(strlen($row['mobile']) === 0){
                        unset($rows[$index]);
                        continue;
                    }

                    //電話號碼不為8位的 地區號碼改成86
                    if(strlen($row['mobile']) !== 8){
                        $row['code'] = '86';
                    }

                    //等級
                    $row['level'] = '上流糧粉';

                    //如果過去12個月：有惠顧、有積分 - 分數照轉
                    //如果過去12個月：沒有惠顧、有積分 - 積分0
                    //如果過去12個月：沒有惠顧、沒有積 - 積分0
                    $last_visit = $row['last_visit'] == '' ? Carbon::parse('2000-01-01') : Carbon::parse($row['last_visit']);
                    $today_last_year = Carbon::now()->subYear();

                    if($last_visit->lt($today_last_year)){
                        $row['point'] = 0;
                    }

                    //姓別 (M/F)
                    if($row['sex'] === 'male'){
                        $row['sex'] = 'M';
                    }else if ($row['sex'] === 'female'){
                        $row['sex'] = 'F';
                    }

                    //生日日期 (MMDD / MDD)
                    $row['date_of_birth'] = Carbon::parse($row['date_of_birth'])->isoFormat('MMDD');

                    ///創建日期加00:00:00
                    $row['create_date'] = $row['create_date']. ' 00:00:00';

                    //到期日期
                    $row['expiry_date'] = '2023-12-31 23:59:59';
                }

                return $rows;
            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new CrmData(), function (Show $show) {
            $show->field('id');
            $show->field('name');
            $show->field('level');
            $show->field('sex');
            $show->field('date_of_birth');
            $show->field('mobile');
            $show->field('email');
            $show->field('last_visit');
            $show->field('create_date');
            $show->field('expiry_date');
            $show->field('point');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new CrmData(), function (Form $form) {
            $form->display('id');
            $form->text('name');
            $form->text('level');
            $form->text('sex');
            $form->text('date_of_birth');
            $form->text('mobile');
            $form->text('email');
            $form->text('last_visit');
            $form->text('create_date');
            $form->text('expiry_date');
            $form->text('point');
        });
    }
}
