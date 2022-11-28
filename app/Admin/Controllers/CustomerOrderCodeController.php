<?php

namespace App\Admin\Controllers;

use App\Models\CustomerOrderCode;
use App\Models\ShopGroup;
use App\Models\WorkshopProduct;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Widgets\Alert;
use Dcat\Admin\Widgets\Card;
use Illuminate\Validation\Rule;

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

            $grid->header(function ($collection) {
                $alertText = '注意！此頁面僅提供修改及刪除已匹配資料功能。如需匹配資料，請於前台進行匹配。';
//                $grid->html(Alert::make($alertText, '提示')->info());
                $card = Card::make('', Alert::make($alertText, '提示')->danger());

                return $card;
            });

            $grid->disableCreateButton();

            $grid->model()->with(['product', 'shop_group']);
            $grid->column('id')->sortable();
            $grid->column('shop_group.name')->filter();
            $grid->column('product.product_no')->filter();
            $grid->column('product.product_name')->filter();
            $grid->column('customer_order_code')->filter();
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                // 更改为 panel 布局
                $filter->panel();

                $filter->equal('shop_group_id', '分組')->select(getReportShop()->forget([ShopGroup::KB_SHOP_ID, ShopGroup::RB_SHOP_ID]));
                $filter->like('product.product_no');
                $filter->like('product.product_name');
                $filter->like('customer_order_code');
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
        return Form::make(CustomerOrderCode::with(['product', 'shop_group']), function (Form $form) {
            $form->display('id');

//            if($form->isCreating()){
//                $form->select('shop_group_id')->options(ShopGroup::getCustomerGroup()->pluck('name', 'id'))->required();
////                $form->select('product_id')->options(WorkshopProduct::getCustomerGroup()->pluck('CodeProduct', 'id'))->required();
//            }

            if($form->isEditing()){
                $form->hidden('shop_group_id');
                $form->display('shop_group.name');
                $form->display('product.product_no');
                $form->display('product.product_name');
            }

            $shop_group_id = $form->input('shop_group_id');
            $form->text('customer_order_code')->required()->rules([
                "required",
                Rule::unique('customer_order_codes', 'customer_order_code')->where(function ($query) use($shop_group_id){
                    return $query->where('shop_group_id', $shop_group_id);
                })->ignore($form->getKey()),
            ],
                [
                    'unique' => '編號已存在',
                ]);
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
