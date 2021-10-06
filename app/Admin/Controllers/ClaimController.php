<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Grid\RowApproveClaim;
use App\Admin\Forms\ApproveClaim;
use App\Admin\Forms\Invoice;
use App\Models\Claim;
use App\Models\ClaimLevel;
use App\Models\Employee;
use Carbon\Carbon;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Widgets\Modal;

class ClaimController extends AdminController
{
    protected $status = [ 0 => '申請中', 1 => '已批核', 2 => '不理賠'];
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Claim(), function (Grid $grid) {

            if(Admin::user()->isAdministrator() === false){
                // 禁用创建按钮
                $grid->disableCreateButton();
                // 禁用行操作按钮
                $grid->disableActions();
            }

            $grid->model()->with(['user', 'employee', 'claim_level', 'illness']);
            $grid->column('id')->sortable();
            $grid->column('employee.name', '員工')->link(admin_url('claims' , ['employee_id' => 1]));
            $grid->column('claim_level.plan_no', '索償等級');
            $grid->column('claim_level.type_name', '索償類型');
            $grid->column('user.name', '批准人');
            $grid->column('illness.item_name', '病症');
            $grid->column('cost');
            $grid->column('claim_cost');
            $grid->column('claim_date');
            $grid->column('status')
                ->using($this->status)
                ->dot(
                    [
                        0 => 'warning',
                        1 => 'success',
                        2 => 'danger',
                    ],
                    'success' // 默认颜色
                );
//            $grid->column('status')->radio($this->status);
            $grid->column('file_path', '圖片')->display(function ($file_path) {
                if($file_path){
                    return '<a href="' . $file_path . '" target="_blank">查看</a>';
                }
            });
            $grid->column('remark');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->column('button2','審批')->display('審批')->modal(function ($modal) {
                return ApproveClaim::make()->payload(['id' => $this->id]);
            });

            $grid->filter(function (Grid\Filter $filter) {
                $filter->panel();
                $filter->equal('id');
                $filter->equal('employee_id')->select(Employee::all()->pluck('name', 'id'));
                $filter->equal('status')->select($this->status);
                $filter->between('claim_date')->date();

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
        return Show::make($id, new Claim(), function (Show $show) {
            $show->field('id');
            $show->field('employee_id');
            $show->field('claim_level_id');
            $show->field('approver_id');
            $show->field('illness_id');
            $show->field('claim_date');
            $show->field('status');
            $show->field('file_path');
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
        return Form::make(new Claim(), function (Form $form) {
//            $form->model()->with('users');
            $form->display('id');
            $form->select('employee_id')
                ->options(Employee::all()->pluck('name', 'id'))
                ->required();
            $form->text('claim_level_id')->required();
//            $form->text('approver_id');
//            $form->display('users.name', '批准人');
            $form->text('illness_id')->required();
            $form->text('cost','實際金額')
                ->rules('required|numeric|min:0.00')
                ->required();
            $form->date('claim_date')->required();
            $form->select('status')->options($this->status);
            $form->text('file_path');

            $form->display('created_at');
            $form->display('updated_at');

            $form->hidden('claim_cost');

            $form->saving(function (Form $form) {
                // 获取用户提交参数
                $cost = $form->input('cost');
                $claim_level_id = $form->input('claim_level_id');

                //索償百分比為0-100
                $claim_level = ClaimLevel::where('id', $claim_level_id)->first();
                $rate = $claim_level->rate;
                $max_claim_money = $claim_level->max_claim_money;
                $claim_cost = $cost * $rate / 100 ;

                if($claim_cost > $max_claim_money){
                    $claim_cost = $max_claim_money;
                }

                $form->input('claim_cost', $claim_cost);

            });
        });
    }

    // 普通非异步弹窗
    protected function modal1()
    {
        return Modal::make()
            ->lg()
            ->title('弹窗')
            ->body($this->table())
            ->button('<button class="btn btn-white"><i class="feather icon-grid"></i> 普通弹窗</button>');
    }
}
