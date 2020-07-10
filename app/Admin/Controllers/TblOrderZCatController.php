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
            $grid->id->sortable();
            $grid->chr_name;
            $grid->int_sort;
            $grid->status;
            $grid->int_page;
            $grid->created_at;
            $grid->updated_at->sortable();
        
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
        return Show::make($id, new TblOrderZCat(), function (Show $show) {
            $show->id;
            $show->chr_name;
            $show->int_sort;
            $show->status;
            $show->int_page;
            $show->created_at;
            $show->updated_at;
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
            $form->display('id');
            $form->text('chr_name');
            $form->text('int_sort');
            $form->text('status');
            $form->text('int_page');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
