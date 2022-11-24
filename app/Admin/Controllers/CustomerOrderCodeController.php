<?php

namespace App\Admin\Controllers;

use App\Models\CustomerOrderCode;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class CustomerOrderCodeController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new CustomerOrderCode(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('shop_group_id');
            $grid->column('product_id');
            $grid->column('customer_order_code');
            $grid->column('created_at');
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
        return Show::make($id, new CustomerOrderCode(), function (Show $show) {
            $show->field('id');
            $show->field('shop_group_id');
            $show->field('product_id');
            $show->field('customer_order_code');
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
        return Form::make(new CustomerOrderCode(), function (Form $form) {
            $form->display('id');
            $form->text('shop_group_id');
            $form->text('product_id');
            $form->text('customer_order_code');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
