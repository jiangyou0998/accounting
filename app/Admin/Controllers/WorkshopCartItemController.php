<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\Tools\BatchCartItemDelete;
use App\Admin\Renderable\CartitemLog;
use App\Admin\Renderable\ProductTable;
use App\Models\WorkshopCartItem;
use App\Models\WorkshopProduct;
use App\User;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Widgets\Alert;

class WorkshopCartItemController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new WorkshopCartItem(), function (Grid $grid) {

            $grid->model()
                ->with('users')
                ->with('products')
                ->orderByDesc('id');

            $grid->batchActions([
                new BatchCartItemDelete('批量刪除', 1)
            ]);

            $grid->showQuickEditButton();
            // 禁用创建按钮
            $grid->disableCreateButton();

            $grid->column('id')->sortable();
            $grid->column('users.txt_name', '分店');
            $grid->column('products.product_name', '產品');
            $grid->column('qty')->label();

            $grid->column('qty_received')->if(function ($column) {
                // 获取当前行其他字段值
                if ($this->qty == $this->qty_received) {
                    return $column->getValue();
                } else {
                    return $column->label('danger');
                }

            });

            $grid->log->display('LOG')->expand(function () {
                // 允许在比包内返回异步加载类的实例
                return CartitemLog::make(['id' => $this->id]);
            });
//            $grid->column('qty_received')->label('danger');
            $grid->column('ip');
            $grid->status->using([1 => '正常', 99 => '正常', 4 => '刪除'])
                ->dot(
                    [
                        4 => 'danger',
                    ],
                    'success' // 默认颜色
                );
//            $grid->column('chr_phase')->hide();
            $grid->column('deli_date')->sortable();
            $grid->column('dept')->using(
                config('dept.symbol_and_name_all'));
            $grid->column('insert_date')->sortable();
            $grid->column('order_date')->hide();
            $grid->column('received_date')->sortable();
            $grid->column('reason');

            $grid->selector(function (Grid\Tools\Selector $selector) {

                $shop = User::getKingBakeryShops()->toArray();
                $rbshop = User::getRyoyuBakeryShops()->toArray();
                $cushop = User::getCustomerShops()->toArray();
                $shops = array_column($shop, 'report_name', 'id');
                $rbshops = array_column($rbshop, 'report_name', 'id');
                $cushops = array_column($cushop, 'report_name', 'id');

                $selector->select('user_id', '蛋撻王', $shops);
                $selector->select('user_id2', '糧友', $rbshops, function ($query, $value) {

                    $query->where('user_id', $value);
                });

                $selector->select('user_id3', '外客', $cushops, function ($query, $value) {

                    $query->where('user_id', $value);
                });

                $selector->selectOne('status', '狀態', [
                    1 => '正常',
                    4 => '刪除',
                ], function ($query, $value) {

//                    $value = current($value);

                    if ($value == 1) {
                        $query->where('status', '!=', 4);
                    } else if ($value == 4) {
                        $query->where('status', '=', 4);
                    }

                });

                $depts = config('dept.symbol_and_name_all');
                $depts['CU'] = '外客';
                $selector->select('dept', '部門', $depts);

                $selector->select('change', '修改過', [
                    1 => '有改過',
                    0 => '沒改過',
                ], function ($query, $value) {

                    $value = current($value);

                    if ($value == 1) {
                        $query->whereRaw('(qty - qty_received) != 0');
                    } else {
                        $query->whereRaw('(qty - qty_received) = 0');
                    }

                });

                $selector->select('logcount', 'Log數量', [
                    1 => '大於1',
                    0 => '小於等於1',
                ], function ($query, $value) {

                    $value = current($value);

                    if ($value == 1) {
                        $query->has('cart_item_logs','>',1);
                    } else {
                        $query->has('cart_item_logs','<=',1);
                    }

                });


                $selector->select('reason', '原因', [
                    '品質問題 (壞貨)' => '品質問題 (壞貨)',
                    '執漏貨' => '執漏貨',
                    '執錯貨' => '執錯貨',
                    '分店落錯貨，即日收走' => '分店落錯貨，即日收走',
                    '打錯單' => '打錯單',
                    '抄碼' => '抄碼',
                    '運送途中損爛' => '運送途中損爛',
                    '運輸送錯分店' => '運輸送錯分店',
                    '缺貨' => '缺貨',
                    '廠派貨' => '廠派貨',
                    '分店要求扣數' => '分店要求扣數',
                    '分店要求加單' => '分店要求加單',
                    '不明原因' => '不明原因'
                ]);

                $selector->select('hasreason', '有無原因', [
                    1 => '有原因',
                    0 => '無原因',
                ], function ($query, $value) {

                    $value = current($value);

                    if ($value == 1) {

                        $query->whereNotNull('reason');
                    } else {
                        $query->whereNull('reason');
                    }

                });

                $selector->select('repeat', '有無重複', [
                    1 => '有重複',
                ], function ($query, $value) {

                    $value = current($value);

//                    $query->whereIn('(product_id,user_id,po_no)', function($query){
//                        $query->select('product_id,user_id,po_no')
//                            ->from('workshop_cart_items')
//                            ->where('status' ,'<>', 4)
//                            ->groupByRaw('product_id,user_id,po_no')
//                            ->havingRaw('count(*) > 1');
//                    });
                    $query->whereRaw('
                    (product_id,user_id,po_no) IN (SELECT
                        product_id,user_id,po_no
                    FROM
                        `workshop_cart_items`
                    WHERE
                        `status` <> 4
                    GROUP BY product_id , user_id , po_no
                    HAVING COUNT(*) > 1)')
                        ->orderByDesc('po_no')->orderBy('user_id')->orderBy('product_id');


                });

            });

            $grid->filter(function (Grid\Filter $filter) {
                // 更改为 panel 布局
                $filter->panel();
                $filter->equal( 'id');
                $filter->between('insert_date', '插入時間')->datetime();

                $filter->between('order_date', '更新時間')->datetime();

                $filter->between('deli_date', '送貨時間')->date();

                $filter->between('received_date', '確認時間')->datetime();
                $filter->in('product_id', '產品')
                    ->multipleSelectTable(ProductTable::make()) // 设置渲染类实例，并传递自定义参数
                    ->title('弹窗标题')
                    ->dialogWidth('50%') // 弹窗宽度，默认 800px
                    ->model(WorkshopProduct::class, 'id', 'product_name'); // 设置编辑数据显示
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
        $builder = new WorkshopCartItem();
        $builder = $builder->with(['users','products']);

        return Form::make($builder, function (Form $form) {
            $form->display('id');
            $form->display('users.txt_name', '分店');
            $form->display('products.product_name', '產品');
            $form->text('qty');
            $form->text('order_price','下單價格');
            $description = '1:下單&nbsp;&nbsp;&nbsp;99:確認過&nbsp;&nbsp;&nbsp;4:刪除';
            $form->html(Alert::make($description, '说明')->info());
            $form->text('status')->type('number');
            $form->select('dept')->options(config('dept.symbol_and_name_all'));
            $form->text('qty_received');
            $form->text('reason');

        });
    }
}
