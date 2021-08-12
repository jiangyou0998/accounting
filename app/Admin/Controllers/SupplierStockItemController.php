<?php

namespace App\Admin\Controllers;

use App\Models\Supplier\Supplier;
use App\Models\Supplier\SupplierProduct;
use App\Models\WorkshopUnit;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class SupplierStockItemController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new SupplierProduct(), function (Grid $grid) {
            $grid->model()->with(['supplier', 'unit', 'base_unit']);

            $grid->column('id')->sortable();
            $grid->column('product_name');
            $grid->column('product_no');
            $grid->column('supplier.name','供應商');
//            $grid->column('group_id');
            $grid->column('unit.unit_name', '單位');
            $grid->column('base_qty', '包裝數量');
            $grid->column('base_unit.unit_name', '包裝單位');
            $grid->column('weight');
            $grid->column('weight_unit');
            $grid->column('default_price');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');

            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new SupplierProduct(), function (Form $form) {
            $form->model()->with(['supplier', 'unit', 'base_unit']);
            $form->display('id');
            $form->text('product_name');
            $form->text('product_no');
            $form->select('supplier_id','供應商')->options(Supplier::all()->pluck('name','id'));
            $form->text('group_id');
            $form->select('unit_id', '單位')->options(WorkshopUnit::all()->pluck('unit_name','id'));
            $form->select('base_unit_id', '包裝單位')->options(WorkshopUnit::all()->pluck('unit_name','id'));
            $form->text('base_qty', '包裝數量');
            $form->text('default_price');
            $form->text('weight');
            $form->text('weight_unit');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
