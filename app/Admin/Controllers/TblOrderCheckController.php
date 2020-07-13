<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\TblOrderCheck;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class TblOrderCheckController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new TblOrderCheck(), function (Grid $grid) {
            $grid->int_id->sortable();
            $grid->chr_report_name;
            $grid->int_num_of_day;
            $grid->int_sort;
        
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
        return Show::make($id, new TblOrderCheck(), function (Show $show) {
            $show->int_id;
            $show->chr_report_name;
            $show->int_num_of_day;
            $show->int_sort;
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new TblOrderCheck(), function (Form $form) {
            $form->display('int_id');
            $form->text('chr_report_name');
            $form->text('int_num_of_day');
            $form->text('int_sort');
        });
    }
}
