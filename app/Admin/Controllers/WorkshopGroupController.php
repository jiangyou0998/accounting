<?php

namespace App\Admin\Controllers;

use App\Models\WorkshopGroup;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class WorkshopGroupController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new WorkshopGroup(), function (Grid $grid) {
            $grid->id->sortable();
            $grid->group_name;
            $grid->sort;
            $grid->status;
            $grid->cat_id;
            $grid->short_name;
            $grid->last_modify;
        
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
        return Show::make($id, new WorkshopGroup(), function (Show $show) {
            $show->id;
            $show->group_name;
            $show->sort;
            $show->status;
            $show->cat_id;
            $show->short_name;
            $show->last_modify;
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new WorkshopGroup(), function (Form $form) {
            $form->display('id');
            $form->text('group_name');
            $form->text('sort');
            $form->text('status');
            $form->text('cat_id');
            $form->text('short_name');
            $form->text('last_modify');
        });
    }
}
