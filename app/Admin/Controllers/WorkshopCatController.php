<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\TblOrderZCat;
use App\Models\WorkshopCat;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class WorkshopCatController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new WorkshopCat(), function (Grid $grid) {

            $grid->model()->orderBy('sort');
            $grid->cat_name;
            $grid->sort;
            $grid->status;
            $grid->start_date;
            $grid->end_date;

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
        return Form::make(new WorkshopCat(), function (Form $form) {

            $form->disableEditingCheck();

            $form->disableCreatingCheck();

            $form->disableViewCheck();

            $form->tools(function (Form\Tools $tools) {

                // 去掉`删除`按钮
                $tools->disableDelete();

                // 去掉`查看`按钮
                $tools->disableView();

            });

            $form->text('cat_name');
            $form->text('sort');
            $form->text('status');
            $form->dateRange('start_date', 'end_date', '生效時間');

        });
    }
}
