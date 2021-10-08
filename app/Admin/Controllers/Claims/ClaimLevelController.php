<?php

namespace App\Admin\Controllers\Claims;

use App\Admin\Renderable\ClaimLevelDetailTable;
use App\Models\ClaimLevel;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Widgets\Alert;
use Dcat\Admin\Widgets\Card;
use Illuminate\Support\Facades\DB;

class ClaimLevelController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new ClaimLevel(), function (Grid $grid) {
//            $grid->column('id')->sortable();
            $grid->header(function ($collection) {
                $alertText = '注意！相同分組共用索償次數！';
//                $grid->html(Alert::make($alertText, '提示')->info());
                $card = Card::make('', Alert::make($alertText, '提示')->danger());

                return $card;
            });

            $grid->model()->orderBy('plan_no');
            $grid->column('plan_no')->display(function($plan_no){
                return 'Plan'.$plan_no;
            });

            $grid->column('plan_code')->display(function($plan_no){
                return '分組'.$plan_no;
            });

            $grid->column('type_name')->link(function ($type_name) {
                $id = $this->id;
                $url = admin_url('claim_level_details')."?claim_level_id={$id}";

                return $url;
            });

            $grid->filter(function (Grid\Filter $filter) {
                $filter->panel();
                $filter->equal('plan_no');

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
        return Show::make($id, new ClaimLevel(), function (Show $show) {
            $show->field('id');
            $show->field('plan_no');
            $show->field('max_claim_money');
            $show->field('rate');
            $show->field('type_name');
            $show->field('times_per_day');
            $show->field('times_per_year');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $builder = new ClaimLevel();
//        $builder = $builder->with('details');

        return Form::make($builder, function (Form $form) {
            $form->display('id');
            $form->text('plan_no')->required();
            $form->text('plan_code')->required()->placeholder('相同分組共用次數');
            $form->text('type_name')->required()->placeholder('例如：門診、住院');

//            $form->hasMany('details', '索償設置', function (Form\NestedForm $form){
//                $form->text('max_claim_money')
//                    ->rules('required|numeric|min:0.00')
//                    ->required();
//                $form->rate('rate')->required()
//                    ->attribute('min', 0)
//                    ->attribute('max', 100);
//                $form->number('times_per_day')->required()
//                    ->attribute('min', 1)
//                    ->default(1);
//                $form->number('times_per_year')->required()
//                    ->attribute('min', 1)
//                    ->default(1);
//                $form->dateRange('start_date','end_date','生效時間')->required();
////                $form->date('end_date')->required();
//
//            });

        });
    }
}
