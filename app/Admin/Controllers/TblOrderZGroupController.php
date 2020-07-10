<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\TblOrderZGroup;
use App\Models\TblOrderZCat;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class TblOrderZGroupController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new TblOrderZGroup(['tblOrderZCat']), function (Grid $grid) {
            $grid->chr_name->editable();
            $grid->int_sort;
            $grid->status;
            $grid->column('tblOrderZCat.chr_name',"大類");

//            $cat = new TblOrderZCat();
//            dd($cat::all()->tblOrderZCat());

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
        return Show::make($id, new TblOrderZGroup(), function (Show $show) {
            $show->int_id;
            $show->chr_name;
            $show->int_sort;
            $show->status;
            $show->int_cat;
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new TblOrderZGroup(), function (Form $form) {
            $form->display('int_id');
            $form->text('chr_name');
            $form->text('int_sort');
            $form->text('status');
            $form->text('int_cat');
        });
    }
}
