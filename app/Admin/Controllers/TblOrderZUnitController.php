<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\TblOrderZUnit;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class TblOrderZUnitController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new TblOrderZUnit(), function (Grid $grid) {
            $grid->int_id->sortable();
            $grid->chr_name;
        
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
        return Show::make($id, new TblOrderZUnit(), function (Show $show) {
            $show->int_id;
            $show->chr_name;
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new TblOrderZUnit(), function (Form $form) {
            $form->display('int_id');
            $form->text('chr_name');
        });
    }
}
