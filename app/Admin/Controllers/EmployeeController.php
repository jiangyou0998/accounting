<?php

namespace App\Admin\Controllers;

use App\Admin\Renderable\UserTable;
use App\Models\Employee;
use Carbon\Carbon;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Widgets\Alert;

class EmployeeController extends AdminController
{
    protected $is_worked = [0 => '離職', 1 => '在職'];
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Employee(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('name');
            $grid->column('code');
            $grid->column('title');
            $grid->column('claim_level');
            $grid->column('is_worked')
                ->using($this->is_worked)
                ->dot(
                [
                    0 => 'danger',
                    1 => 'success',
                ],
                'success' // 默认颜色
            );
            $grid->column('employment_date');
            $grid->column('leave_date');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->like('name');
                $filter->equal('is_worked','在職狀態')->select($this->is_worked);

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
        return Show::make($id, new Employee(), function (Show $show) {
            $show->field('id');
            $show->field('name');
            $show->field('code');
            $show->field('claim_level');
            $show->field('is_worked');
            $show->field('leave_date');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Employee(), function (Form $form) {
            $form->display('id');
            $form->text('name')->required();
            $form->text('code')->required()->rules("required|
                max:7|unique:employees,code,{$form->getKey()},id", [
                'max' => '編號最大長度為7',
                'unique'   => '編號已存在',
            ]);
            $form->text('title')->required();
            $form->text('claim_level')->required();
            $form->date('employment_date')->required();
            $form->radio('is_worked')
                ->when(0, function (Form $form) {
                    $alertText = '離職日期不填寫，默認為今天';
                    $form->html(Alert::make($alertText, '提示')->info());
                    $form->date('leave_date');
                })
                ->options([0 => '離職' , 1 => '在職'])
                ->default(1);

//            $form->editing(function (Form $form) {
//                $form->display('leave_date');
//            });

            $form->display('created_at');
            $form->display('updated_at');
//            $form->hidden('leave_date');

            $form->saving(function (Form $form) {
                // 获取用户提交参数
                $is_worked = $form->input('is_worked');
                $leave_date = $form->input('leave_date');

                if($is_worked == 0 && $leave_date == ''){
                    $now = Carbon::now()->toDateString();
                    $form->leave_date = $now;
                }else if($is_worked == 1){
                    $form->leave_date = null;
                }


            });
        });
    }
}
