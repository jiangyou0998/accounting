<?php

namespace App\Admin\Controllers;

use App\Models\SalesIncomeType;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class SalesIncomeTypeController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new SalesIncomeType(), function (Grid $grid) {

            $grid->disableDeleteButton();

            $grid->column('id')->sortable();
            $grid->column('type_no');
            $grid->column('name');
            $grid->column('remark');

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');

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
        return Show::make($id, new SalesIncomeType(), function (Show $show) {
            $show->field('id');
            $show->field('type_no');
            $show->field('name');
            $show->field('remark');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new SalesIncomeType(), function (Form $form) {
            $form->display('id');
            $form->text('type_no');
            $form->text('name');
            $form->text('remark');

        });
    }
}
