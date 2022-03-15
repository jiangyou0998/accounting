<?php

namespace App\Admin\Controllers\Reports;

use App\Models\Repairs\RepairDetail;
use App\Models\Repairs\RepairItem;
use App\Models\Repairs\RepairLocation;
use App\Models\Repairs\RepairProject;
use App\User;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class RepairProjectController extends AdminController
{
    const STATUS = [
            RepairProject::STATUS_UNFINISHED => '未完成',
            RepairProject::STATUS_CANCELED => '已取消',
            RepairProject::STATUS_NEED_FOLLOWED => '需跟進',
            RepairProject::STATUS_FINISHED => '已完成',
        ];
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new RepairProject(), function (Grid $grid) {

            // 禁用行选择器
            $grid->disableRowSelector();
            $grid->disableCreateButton();
            $grid->disableActions();
            $grid->disableBatchDelete();

            $grid->model()->with(['users', 'locations', 'items', 'details', 'order']);
            $grid->column('id')->sortable();

            $grid->column('repair_project_no')->filterByValue();
            $grid->column('created_at', '落單日期');
            $grid->column('users.txt_name', '分店/用戶')->filterByValue();
            $grid->column('locations.name', '位置');
            $grid->column('items.name', '維修項目');
            $grid->column('details.name', '求助事宜');
//            $grid->column('ip');
            $grid->column('status')->using(self::STATUS)
                ->dot(
                    [
                        RepairProject::STATUS_UNFINISHED => 'warning',
                        RepairProject::STATUS_CANCELED => 'danger',
                        RepairProject::STATUS_NEED_FOLLOWED => 'primary',
                        RepairProject::STATUS_FINISHED => 'success',
                    ],
                    'success' // 默认颜色
                );
            $grid->column('machine_code');
            $grid->column('other');
            $grid->column('file_path')->display(function ($file_path) {
                if($file_path){
                    return '<a href="' . $file_path . '" target="_blank">查看</a>';
                }
            });
//            $grid->column('last_update_user');
            $grid->column('comment')->width('200px');
            $grid->column('contact_person');
            $grid->column('order.complete_date', '完成日期');
            $grid->column('order.order_no', '維修單號碼')->filterByValue();
            $grid->column('fee', '維修費用');
//            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->panel();
//                $filter->equal('status')->select(self::STATUS);
//                $filter->equal('repair_location_id', '位置')->select(RepairLocation::all()->pluck('name','id'));
//                $filter->equal('repair_item_id', '維修項目')->select(RepairItem::all()->pluck('name','id'));
//                $filter->equal('repair_detail_id', '求助事宜')->select(RepairDetail::all()->pluck('name','id'));
                $filter->like('order.order_no', '維修單號碼');

            });

            $titles = [
                'users.txt_name' => '分店/用戶',
                'locations.name' => '位置',
                'items.name' => '維修項目',
                'details.name' => '求助事宜',
                'status' => '狀態',
                'order.complete_date' => '完成日期',
                'order.order_no' => '維修單號碼',
                'fee' => '維修費用',
            ];

            $grid->export($titles)->rows(function (array $rows) use ($titles){
                foreach ($rows as $index => &$row) {
                    foreach ($titles as $key => $value){
                        $row[$key] = data_get($row, $key, '');
                    }
                    $row['status'] = self::STATUS[$row['status']];
                }
                return $rows;
            })->csv();

            //選擇器
            $grid->selector(function (Grid\Tools\Selector $selector){
                
                $rbshop = User::getRyoyuBakeryShops()->toArray();

                $rbshops = array_column($rbshop, 'report_name', 'id');

                $selector->select('user_id', '糧友', $rbshops);

                $selector->select('status', '狀態', self::STATUS);
                $selector->select('repair_location_id', '位置', RepairLocation::all()->pluck('name','id'));
                $selector->select('repair_item_id', '維修項目', RepairItem::all()->pluck('name','id'));
                $selector->select('repair_detail_id', '求助事宜', RepairDetail::all()->pluck('name','id'));

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
        return Show::make($id, new RepairProject(), function (Show $show) {
            $show->field('id');
            $show->field('repair_project_no');
            $show->field('ip');
            $show->field('status');
            $show->field('machine_code');
            $show->field('other');
            $show->field('file_path');
            $show->field('last_update_user');
            $show->field('comment');
            $show->field('contact_person');
            $show->field('repair_order_id');
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
        return Form::make(new RepairProject(), function (Form $form) {
            $form->display('id');
            $form->text('repair_project_no');
            $form->text('ip');
            $form->text('status');
            $form->text('machine_code');
            $form->text('other');
            $form->text('file_path');
            $form->text('last_update_user');
            $form->text('comment');
            $form->text('contact_person');
            $form->text('repair_order_id');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
