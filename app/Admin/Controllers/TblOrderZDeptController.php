<?php

namespace App\Admin\Controllers;

use App\Admin\Renderable\ProductTable;
use App\Models\TblOrderZDept;
use App\Models\TblOrderZMenu;
use App\Models\TblUser;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Widgets\Alert;
use Symfony\Component\Console\Input\Input;

class TblOrderZDeptController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new TblOrderZDept(), function (Grid $grid) {

            $grid->model()
                ->with('users')
                ->with('products')
                ->orderByDesc('chr_po_no');

            $grid->showQuickEditButton();
            // 禁用创建按钮
            $grid->disableCreateButton();

            $grid->column('users.txt_name','分店');
            $grid->column('products.chr_name','產品');
            $grid->column('int_qty')->label();

            $grid->column('int_qty_received')->if(function ($column) {
                // 获取当前行其他字段值
                if($this->int_qty == $this->int_qty_received){
                    return $column->getValue();
                }else{
                    return $column->label('danger');
                }

            });
//            $grid->column('int_qty_received')->label('danger');
            $grid->column('chr_ip');
            $grid->status->using([1 => '正常', 99 => '正常', 4 => '刪除'])
                ->dot(
                    [
                        4 => 'danger',
                    ],
                    'success' // 默认颜色
                );
            $grid->column('chr_phase')->hide();
            $grid->column('chr_po_no');
            $grid->column('chr_dept')->using(
                ['R' => '烘焙',
                'B' => '水吧',
                'K' => '廚房',
                'F' => '樓面']);
            $grid->column('insert_date');
            $grid->column('order_date')->hide();
            $grid->column('received_date');
            $grid->column('reason');

            $grid->selector(function (Grid\Tools\Selector $selector) {

                $kbshop = TblUser::getKingBakeryShops()->toArray();
                $kbshops = array_column($kbshop, 'chr_report_name','int_id');

                $selector->select('int_user', '分店', $kbshops);

                $selector->selectOne('status', '狀態', [
                    1 => '正常',
                    4 => '刪除',
                ],function ($query, $value) {

//                    $value = current($value);

                    if($value == 1){
                        $query->where('status','!=',4);
                    }else if($value == 4){
                        $query->where('status','=',4);
                    }

                });

                $selector->select('chr_dept', '部門', [
                    'R' => '烘焙',
                    'B' => '水吧',
                    'K' => '廚房',
                    'F' => '樓面',
                ]);

                $selector->select('change', '修改過', [
                    1 => '有改過',
                    0 => '沒改過',
                ],function ($query, $value) {

                    $value = current($value);

                    if($value == 1){
                        $query->whereRaw('(int_qty - int_qty_received) != 0');
                    }else{
                        $query->whereRaw('(int_qty - int_qty_received) = 0');
                    }

                });

                $selector->select('reason', '原因', [
                    '品質問題 (壞貨)'=>'品質問題 (壞貨)',
                    '執漏貨'=>'執漏貨',
                    '執錯貨'=>'執錯貨',
                    '分店落錯貨，即日收走'=>'分店落錯貨，即日收走',
                    '打錯單'=>'打錯單',
                    '抄碼'=>'抄碼',
                    '運送途中損爛'=>'運送途中損爛',
                    '運輸送錯分店'=>'運輸送錯分店',
                    '缺貨'=>'缺貨',
                    '廠派貨'=>'廠派貨',
                    '分店要求扣數'=>'分店要求扣數',
                    '分店要求加單'=>'分店要求加單',
                    '不明原因'=>'不明原因'
                ]);

                $selector->select('hasreason', '有無原因', [
                    1 => '有原因',
                    0 => '無原因',
                ],function ($query, $value) {

                    $value = current($value);

                    if($value == 1){

                        $query->whereNotNull('reason');
                    }else{
                        $query->whereNull('reason');
                    }

                });

                $selector->select('repeat', '有無重複', [
                    1 => '有重複',
                ],function ($query, $value) {

                    $value = current($value);

//                    $query->whereIn('(int_product,int_user,chr_po_no)', function($query){
//                        $query->select('int_product,int_user,chr_po_no')
//                            ->from('tbl_order_z_dept')
//                            ->where('status' ,'<>', 4)
//                            ->groupByRaw('int_product,int_user,chr_po_no')
//                            ->havingRaw('count(*) > 1');
//                    });
                    $query->whereRaw('
                    (int_product,int_user,chr_po_no) IN (SELECT
                        int_product,int_user,chr_po_no
                    FROM
                        `tbl_order_z_dept`
                    WHERE
                        `status` <> 4
                    GROUP BY int_product , int_user , chr_po_no
                    HAVING COUNT(*) > 1)')
                        ->orderByDesc('chr_po_no')->orderBy('int_user')->orderBy('int_product');


                });

            });

            $grid->filter(function (Grid\Filter $filter) {
                // 更改为 panel 布局
                $filter->panel();
                $filter->between('insert_date','插入時間')->date();
//                $filter->where('deli_date', function ($query) {
//
//                    $query->whereRaw("DATE(DATE_ADD(insert_date, INTERVAL 1+chr_phase DAY)) = '$this->input'");
//
//                }, '送貨時間')->date();
                $filter->whereBetween('deli_date', function ($q) {
                    $start = $this->input['start'] ?? null;
                    $end = $this->input['end'] ?? null;

                    if ($start !== null) {
                        $q->whereRaw("DATE(DATE_ADD(insert_date, INTERVAL 1+chr_phase DAY)) >= '$start'");
                    }

                    if ($end !== null) {
                        $q->whereRaw("DATE(DATE_ADD(insert_date, INTERVAL 1+chr_phase DAY)) <= '$end'");
                    }
                }, '送貨時間')->date();
                $filter->between('received_date','確認時間')->date();
                $filter->in('int_product', '產品')
                    ->multipleSelectTable(ProductTable::make()) // 设置渲染类实例，并传递自定义参数
                    ->title('弹窗标题')
                    ->dialogWidth('50%') // 弹窗宽度，默认 800px
                    ->model(TblOrderZMenu::class, 'int_id', 'chr_name'); // 设置编辑数据显示
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
        return Show::make($id, new TblOrderZDept(), function (Show $show) {
            $show->field('id');
            $show->field('order_date');
            $show->field('int_user');
            $show->field('int_product');
            $show->field('int_qty');
            $show->field('chr_ip');
            $show->field('status');
            $show->field('chr_phase');
            $show->field('chr_po_no');
            $show->field('chr_dept');
            $show->field('insert_date');
            $show->field('int_qty_received');
            $show->field('received_date');
            $show->field('reason');
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
        $builder = new TblOrderZDept();
        $builder = $builder->with('users')
            ->with('products');

        return Form::make($builder, function (Form $form) {
            $form->display('int_id');
            $form->display('users.txt_name','分店');
            $form->display('products.chr_name','產品');
            $form->text('int_qty');
            $description = '1:下單&nbsp;&nbsp;&nbsp;99:確認過&nbsp;&nbsp;&nbsp;4:刪除';
            $form->html(Alert::make($description, '说明')->info());
            $form->text('status')->type('number');
            $form->select('chr_dept')->options([
                'R' => '烘焙',
                'B' => '水吧',
                'K' => '廚房',
                'F' => '樓面',
            ]);
            $form->text('int_qty_received');
            $form->text('reason');

        });
    }
}
