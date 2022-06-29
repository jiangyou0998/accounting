<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Grid\DeleteSupplier;
use App\Models\Supplier\Supplier;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Controllers\AdminController;

class SupplierController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Supplier(), function (Grid $grid) {

            //禁用自帶刪除
            $grid->disableDeleteButton();
            $grid->actions([new DeleteSupplier()]);

            $grid->quickSearch('name');
            $grid->column('id')->sortable();
            $grid->column('name');
            $grid->column('warehouse_used_count')->sortable();
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Supplier(), function (Form $form) {
            $form->display('id');
            $form->text('name')->required()->rules("required|
                unique:suppliers,name,{$form->getKey()},id", [
                'unique'   => '供應商已存在',
            ]);
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
