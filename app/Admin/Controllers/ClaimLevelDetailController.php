<?php

namespace App\Admin\Controllers;

use App\Models\ClaimLevel;
use App\Models\ClaimLevelDetail;
use Carbon\Carbon;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class ClaimLevelDetailController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new ClaimLevelDetail(), function (Grid $grid) {
            $grid->model()
                ->with('claim_level')
                ->orderBy('claim_level_id')
                ->orderBy('start_date');

            $grid->column('id')->sortable();

            $grid->column('claim_level.plan_no', '索償計劃編號')->display(function($plan_no){
                return 'Plan'.$plan_no;
            });
            $grid->column('claim_level.type_name', '索償類別');

            $grid->column('max_claim_money')->display(function($max_claim_money){
                return '$'.number_format($max_claim_money, 2);
            });
            $grid->column('rate')->display(function($rate){
                return $rate.'%';
            });
            $grid->column('times_per_day');
            $grid->column('times_per_year');

            $grid->column('is_invalid', '今天生效')->display(function () {
                if( isDateBetween($this->start_date, $this->end_date, Carbon::now()) ){
                    return '<i class="fa fa-circle" style="font-size: 13px;color: #21b978"></i>&nbsp;&nbsp;是';
                }else{
                    return '<i class="fa fa-circle" style="font-size: 13px;color: #ea5455"></i>&nbsp;&nbsp;否';
                }
            });
            $grid->column('start_date');
            $grid->column('end_date');

            $grid->filter(function (Grid\Filter $filter) {
                $filter->panel();
//                $filter->equal('id');
                $filter->equal('claim_level_id', '索償等級')->select(ClaimLevel::getClaimLevels());

                $filter->where('date', function ($query) {

                    $query->where('start_date', '<=', "{$this->input}")
                        ->where('end_date', '>=', "{$this->input}");

                }, '生效日期')->date();

            });
//
//            $grid->selector(function (Grid\Tools\Selector $selector) {
//                $selector->select('time', '是否使用中', ['0' => '未使用', '1' => '使用中'], function ($query, $value) {
//
//                    if($value == 0){
//                        $query->whereNotBetween('price', $between[$value]);
//                    }
//
//                    $query->whereBetween('price', $between[$value]);
//                });
//            });

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
        return Show::make($id, new ClaimLevelDetail(), function (Show $show) {
            $show->field('id');
            $show->field('claim_level_id');
            $show->field('max_claim_money');
            $show->field('rate');
            $show->field('times_per_day');
            $show->field('times_per_year');
            $show->field('start_date');
            $show->field('end_date');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new ClaimLevelDetail(), function (Form $form) {
            $form->display('id');

            $claim_levels = ClaimLevel::getClaimLevels();

            $form->select('claim_level_id', '索償類別')->options($claim_levels);

            $form->text('max_claim_money')
                ->rules('required|numeric|min:0.00')
                ->required();

            $form->rate('rate')->required()
                ->attribute('min', 0)
                ->attribute('max', 100);

            $form->number('times_per_day')->required()
                ->attribute('min', 1)
                ->default(1);

            $form->number('times_per_year')->required()
                ->attribute('min', 1)
                ->default(1);

            $form->dateRange('start_date', 'end_date', '生效時間');

            $form->submitted(function (Form $form) {
                // 获取用户提交参数
                $id = $form->getKey();
                $check_start_date = $form->start_date;
                $check_end_date = $form->end_date;

                $claim_level_id = $form->claim_level_id;

                if( strtotime($check_start_date) > strtotime($check_end_date) ){
                    return $form->error('「開始時間」不能大於「結束時間」');
                }

                $claim_level_details = ClaimLevelDetail::where('claim_level_id', $claim_level_id)
                    ->where('id', '!=', $id)
                    ->get();

                foreach ($claim_level_details as $claim_level_detail){

                    $start_date = $claim_level_detail->start_date;
                    $end_date = $claim_level_detail->end_date;
                    if( checkTimesHasOverlap($check_start_date, $check_end_date, $start_date, $end_date, true) ){
                        return $form->error('「生效時間」重疊');
                    }

                }


//                dump($claim_level_details);

                // 中断后续逻辑
//                return $form->error($claim_level_id);
            });
        });
    }
}
