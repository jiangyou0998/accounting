<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\TblNotice;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class TblNoticeController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new TblNotice(), function (Grid $grid) {
            $grid->int_no;
            $grid->txt_name;
            $grid->int_dept;
            $grid->txt_path;
            $grid->int_user;
            $grid->date_create;
            $grid->date_modify;
            $grid->date_delete;

            $grid->date_last;
            $grid->first_path;

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('int_id');

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
        return Show::make($id, new TblNotice(), function (Show $show) {
            $show->int_id;
            $show->txt_name;
            $show->int_dept;
            $show->txt_path;
            $show->int_user;
            $show->date_create;
            $show->date_modify;
            $show->date_delete;
            $show->int_no;
            $show->date_last;
            $show->first_path;
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new TblNotice(), function (Form $form) {
            $form->display('int_id');
            $form->text('txt_name');
            $form->text('int_dept');
            $form->text('txt_path');
            $form->text('int_user');
            $form->text('date_create');
            $form->text('date_modify');
            $form->text('date_delete');
            $form->text('int_no');
            $form->text('date_last');
            $form->text('first_path');
        });
    }
}
