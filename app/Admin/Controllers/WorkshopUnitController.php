<?php

namespace App\Admin\Controllers;

use App\Models\WorkshopUnit;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class WorkshopUnitController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new WorkshopUnit(), function (Grid $grid) {
            $grid->id->sortable();
            $grid->unit_name;
        
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
        return Show::make($id, new WorkshopUnit(), function (Show $show) {
            $show->id;
            $show->unit_name;
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new WorkshopUnit(), function (Form $form) {
            $form->display('id');
            $form->text('unit_name');
        });
    }
}
