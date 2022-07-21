<?php

namespace App\Admin\Controllers;

use App\Models\WarehouseStockItemForbidden;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
use Illuminate\Validation\Rule;

class WarehouseStockItemForbiddenController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new WarehouseStockItemForbidden(), function (Grid $grid) {

            //管理員才可以修改
            if(! Admin::user()->isAdministrator()){
                $grid->disableActions();
            }

            $grid->model()
                ->with('users')
                ->orderByDesc('month');
            $grid->column('id')->sortable();
            $grid->column('users.name','操作人');
            $grid->column('month');
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
        return Form::make(new WarehouseStockItemForbidden(), function (Form $form) {
            $form->display('id');
            $form->hidden('user_id');
            $form->month('month')->format('YYYYMM')->required()->rules([
                "required",
                Rule::unique('warehouse_stock_item_forbidden')->ignore($form->getKey()),
            ],
                [
                    'unique' => '「不可操作月份」已存在',
                ]
            );

            $form->display('created_at');
            $form->display('updated_at');

            $form->submitted(function (Form $form) {

                $form->input('user_id', Admin::user()->id);

            });

        });
    }
}
