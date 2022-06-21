<?php

namespace App\Admin\Controllers;

use App\Models\Supplier\Supplier;
use App\Models\SupplierGroup;
use App\Models\WarehouseGroup;
use App\Models\WarehouseProduct;
use App\Models\WorkshopUnit;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Controllers\AdminController;

class WarehouseProductController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new WarehouseProduct(), function (Grid $grid) {
            $grid->model()->with(['supplier', 'supplier_group' , 'warehouse_group', 'unit', 'base_unit']);

            $grid->column('id')->sortable();
            $grid->column('product_no');
            $grid->column('product_name')->limit(20);
            $grid->column('product_name_short')->limit(20);
            $grid->column('supplier.name','供應商');
            $grid->column('warehouse_group.name','貨倉分組');
            $grid->column('supplier_group.name','分類');
//            $grid->column('group_id');
            $grid->column('unit.unit_name', '單位');
            $grid->column('base_qty', '包裝數量');
            $grid->column('base_unit.unit_name', '包裝單位');
            $grid->column('weight');
            $grid->column('weight_unit');
            $grid->column('default_price');
//            $grid->column('base_price');
            $grid->column('status')->using([0 => '啟用', 1 => '禁用'])
                ->dot(
                    [
                        0 => 'success',
                        1 => 'danger',
                        4 => Admin::color()->info(),
                    ],
                    'success' // 默认颜色
                );
            $grid->column('created_at')->hide();
            $grid->column('updated_at')->sortable()->hide();


            $titles = [
                'id' => 'ID',
                'product_no' => '編號',
                'product_name' => '名稱',
                'product_name_short' => '簡略名稱',
                'supplier_id' => '供應商',
                'group_id' => '分類',
                'unit_id' => '單位',
                'base_qty' => '包裝數量',
                'base_unit_id' => '包裝單位',
                'weight' => '重量',
                'weight_unit' => '重量單位',
                'default_price' => '來貨價',
//                'base_price' => '單價',
                'status' => '狀態',
            ];
            $grid->export()->rows(function (array $rows) {
                $status = [0 => '啟用', 1 => '禁用'];
                foreach ($rows as $index => &$row) {
                    $row['supplier_id'] = $row['supplier']['name'];
                    $row['group_id'] = $row['supplier_group']['name'];
                    $row['unit_id'] = $row['unit']['unit_name'];
                    $row['base_unit_id'] = $row['base_unit']['unit_name'];
                    $row['status'] = $status[$row['status']];
                }

                return $rows;
            })->titles($titles);

            $grid->filter(function (Grid\Filter $filter) {
                $filter->panel();
                $filter->equal('id');
                $filter->like('product_name');
                $unitArr = WorkshopUnit::all()->pluck('unit_name', 'id');
                $filter->equal('unit_id', '單位')->select($unitArr);
                $supplierArr = Supplier::all()->pluck('name', 'id');
                $filter->equal('supplier_id', '供應商')->select($supplierArr);
                $filter->equal('status','狀態')->select([0 => '啟用', 1 => '禁用']);
                $filter->equal('base_qty', '包裝數量');
                $filter->equal('weight');
                $filter->equal('weight_unit');

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
        return Form::make(new WarehouseProduct(), function (Form $form) {
            $form->model()->with(['supplier', 'unit', 'base_unit']);
            $form->display('id');
            $form->text('product_no');
            $form->text('product_name');
            $form->text('product_name_short');
            $form->select('supplier_id','供應商')->options(Supplier::all()->pluck('name','id'));
            $form->select('warehouse_group_id', '貨倉用途分組')->options(WarehouseGroup::all()->pluck('name','id'));
            $form->select('group_id')->options(SupplierGroup::all()->pluck('name','id'));
            $form->select('unit_id', '單位')->options(WorkshopUnit::all()->pluck('unit_name','id'));
            $form->select('base_unit_id', '包裝單位')->options(WorkshopUnit::all()->pluck('unit_name','id'));
            $form->text('base_qty', '包裝數量');
            $form->text('default_price');
//            $form->text('base_price');
            $form->text('weight');
            $form->text('weight_unit');
            $form->select('status', '狀態')->options([0 => '啟用', 1 => '禁用']);

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
