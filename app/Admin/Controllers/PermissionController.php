<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Permission;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class PermissionController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Permission(), function (Grid $grid) {
            $grid->model()->with('roles');
            // 禁用创建按钮
//            $grid->disableCreateButton();
            // 禁用行操作按钮
            $grid->disableActions();
            // 禁用行选择器
            $grid->disableRowSelector();

            $grid->id->sortable();
            $grid->name->label();
            $grid->guard_name;
            $grid->roles()->pluck('name')->label('danger');
            $grid->created_at;
            $grid->updated_at->sortable();

        });
    }

    /**
     * Make a forms builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Permission(), function (Form $form) {
            $form->display('id');
            $form->text('name')->required();
            $form->text('guard_name')->required()->default('web');
        });
    }

}
