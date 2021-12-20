<?php

namespace App\Admin\Controllers;


use App\Models\FrontGroup;
use App\Models\Supplier\Supplier;
use App\Models\Supplier\SupplierProduct;
use App\Models\Supplier\SupplierStockItemList;
use App\Models\SupplierGroup;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Controllers\AdminController;

class SupplierStockItemListController extends AdminController
{
    public function index(Content $content)
    {
        return $content
            ->header('供應商庫存產品List')
            ->body($this->grid());
    }

    protected function grid()
    {
        return Grid::make(new SupplierStockItemList(), function (Grid $grid) {

            //禁用快速編輯按鈕
            $grid->disableQuickEditButton();

            if(Admin::user()->isAdministrator() === false){
                // 禁用刪除按钮
                $grid->disableDeleteButton();
            }

            $grid->model()->with('front_group');

            $grid->number();
            $grid->column('front_group.name', '分組');

        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new SupplierStockItemList(), function (Form $form) {
            $form->select('front_group_id', '分組')
                ->options(FrontGroup::all()->pluck('name', 'id'))
                ->required()
                ->rules("required|unique:supplier_stock_item_lists,front_group_id,{$form->getKey()},id", [
                    'unique'   => '分組已存在',
                ]);

//            $suppliers = SupplierProduct::all()->mapToGroups(function ($item, $key) {
//                return [$item['supplier_id'] => [$item['group_id'] => $item]];
//            });
//            dump($suppliers->toArray());

            $products = SupplierProduct::getProducts();
            $supplierArr = Supplier::all()->pluck('name', 'id');
            $groupArr = SupplierGroup::all()->pluck('name', 'id');

//            dd($products->toArray());

            foreach ($products as $supplier_id => $suppliers){
                foreach ($suppliers as $group_id => $groups){
                    $form->listbox('item_list', $supplierArr[$supplier_id].'-'.$groupArr[$group_id])
                        ->options(SupplierProduct::where('supplier_id', $supplier_id)
                            ->where('group_id', $group_id)
                            ->where('status', 0)
                            ->pluck('product_name_short', 'id'));
                }
            }

        });
    }
}
