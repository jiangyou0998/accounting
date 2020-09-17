<?php

namespace App\Admin\Controllers;

use App\Models\WorkshopCartItemLog;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class WorkshopCartItemLogController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new WorkshopCartItemLog(), function (Grid $grid) {
            $grid->model()
                ->with('operate_users')
                ->with('shops')
                ->with('products');

//            $grid->column('id')->sortable();
            $grid->column('operate_users.name');
            $grid->column('shops.name');
            $grid->column('products.product_name');
            $grid->column('method')->filter();
            $grid->column('ip')->filter();
            $grid->column('input');
            $grid->column('created_at')->filter();;
            $grid->column('updated_at')->sortable();

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
        return Show::make($id, new WorkshopCartItemLog(), function (Show $show) {
            $show->field('id');
            $show->field('operate_user_id');
            $show->field('shop_id');
            $show->field('product_id');
            $show->field('method');
            $show->field('ip');
            $show->field('input');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new WorkshopCartItemLog(), function (Form $form) {
            $form->display('id');
            $form->text('operate_user_id');
            $form->text('shop_id');
            $form->text('product_id');
            $form->text('method');
            $form->text('ip');
            $form->text('input');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
