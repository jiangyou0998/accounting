<?php

namespace App\Admin\Controllers;

use App\Admin\Renderable\ProductTable;
use App\Models\WorkshopCartItemLog;
use App\Models\WorkshopProduct;
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
                ->with('products')
                ->with('cart_items')
                ->orderByDesc('updated_at');

//            $grid->column('id')->sortable();
            $grid->column('operate_users.txt_name','操作人');
            $grid->column('shops.txt_name','分店');
            $grid->column('products.product_name','產品名稱');
            $grid->column('cart_items.deli_date','送貨時間');
            $grid->column('method')->filter();
            $grid->column('ip')->filter();
            $grid->column('input');
            $grid->column('created_at')->filter();
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                // 更改为 panel 布局
                $filter->panel();
                $filter->between('created_at')->datetime();

                $filter->between('updated_at')->datetime();

                $filter->between('cart_items.deli_date', '送貨時間')->date();

                $filter->in('products.product_id', '產品')
                    ->multipleSelectTable(ProductTable::make()) // 设置渲染类实例，并传递自定义参数
                    ->title('弹窗标题')
                    ->dialogWidth('50%') // 弹窗宽度，默认 800px
                    ->model(WorkshopProduct::class, 'id', 'product_name'); // 设置编辑数据显示

                $filter->equal('method','方法')->select([
                   'INSERT' => '新增',
                   'UPDATE' => '更新',
                   'DELETE' => '刪除',
                   'MODIFY' => '改單'
                ]);
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
