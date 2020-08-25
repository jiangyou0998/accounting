<?php

namespace App\Admin\Controllers;

use App\Models\WorkshopCheck;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class WorkshopCheckController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new WorkshopCheck(), function (Grid $grid) {
            $grid->id->sortable();
            $grid->int_all_shop;
            $grid->shop_list;
            $grid->item_list;
            $grid->report_name;
            $grid->num_of_day;
            $grid->int_hide;
            $grid->int_main_item;
            $grid->sort;
            $grid->disabled;
        
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
        return Show::make($id, new WorkshopCheck(), function (Show $show) {
            $show->id;
            $show->int_all_shop;
            $show->shop_list;
            $show->item_list;
            $show->report_name;
            $show->num_of_day;
            $show->int_hide;
            $show->int_main_item;
            $show->sort;
            $show->disabled;
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new WorkshopCheck(), function (Form $form) {
            $form->display('id');
            $form->text('int_all_shop');
            $form->text('shop_list');
            $form->text('item_list');
            $form->text('report_name');
            $form->text('num_of_day');
            $form->text('int_hide');
            $form->text('int_main_item');
            $form->text('sort');
            $form->text('disabled');
        });
    }
}
