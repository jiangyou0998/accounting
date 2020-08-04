<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\TblOrderZCat;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class TblOrderZCatController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new TblOrderZCat(), function (Grid $grid) {

            $grid->model()->orderBy('int_sort');
            $grid->chr_name;
            $grid->int_sort;
            $grid->status;
            $grid->start_time;
            $grid->end_time;

            $grid->disableRowSelector();
            $grid->disableCreateButton();
            $grid->disableBatchDelete();
            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->disableView();
                $actions->disableDelete();
            });

        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new TblOrderZCat(), function (Form $form) {

            $form->disableEditingCheck();

            $form->disableCreatingCheck();

            $form->disableViewCheck();

            $form->tools(function (Form\Tools $tools) {

                // 去掉`删除`按钮
                $tools->disableDelete();

                // 去掉`查看`按钮
                $tools->disableView();

            });

            $form->text('chr_name');
            $form->text('int_sort');
            $form->text('status');
            $form->dateRange('start_time', 'end_time', '生效時間');

        });
    }
}
