<?php

namespace App\Admin\Controllers;

use App\Admin\Renderable\CartitemLog;
use App\Admin\Renderable\ProductTable;
use App\Models\TblOrderZDept;
use App\Models\TblOrderZMenu;
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
            $grid->column('chr_phase')->hide();
            $grid->column('po_no');
            $grid->column('dept')->using(
                config('dept.symbol_and_name_all'));
            $grid->column('insert_date');
            $grid->column('order_date')->hide();
            $grid->column('received_date');
            $grid->column('reason');

            $grid->selector(function (Grid\Tools\Selector $selector) {

                $shop = User::getKingBakeryShops()->toArray();
                $shops = array_column($shop, 'report_name', 'id');

                $selector->select('user_id', '分店', $shops);

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

                $selector->select('dept', '部門', config('dept.symbol_and_name_all'));

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
                $filter->between('insert_date', '插入時間')->date();
//                $filter->where('deli_date', function ($query) {
//
//                    $query->whereRaw("DATE(DATE_ADD(insert_date, INTERVAL 1+chr_phase DAY)) = '$this->input'");
//
//                }, '送貨時間')->date();
                $filter->whereBetween('deli_date', function ($q) {
                    $start = $this->input['start'] ?? null;
                    $end = $this->input['end'] ?? null;

                    if ($start !== null) {
                        $q->where("deli_date", '>=', $start);
                    }

                    if ($end !== null) {
                        $q->where("deli_date", '<=', $end);
                    }
                }, '送貨時間')->date();
                $filter->between('received_date', '確認時間')->date();
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
        $builder = new WorkshopProduct();
        $builder = $builder->with('users')
            ->with('products');

        return Form::make($builder, function (Form $form) {
            $form->display('id');
            $form->display('users.txt_name', '分店');
            $form->display('products.product_name', '產品');
            $form->text('qty');
            $description = '1:下單&nbsp;&nbsp;&nbsp;99:確認過&nbsp;&nbsp;&nbsp;4:刪除';
            $form->html(Alert::make($description, '说明')->info());
            $form->text('status')->type('number');
            $form->select('dept')->options(config('dept.symbol_and_name_all'));
            $form->text('qty_received');
            $form->text('reason');

        });
    }
}
