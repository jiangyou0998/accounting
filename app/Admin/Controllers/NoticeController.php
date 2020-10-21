<?php

namespace App\Admin\Controllers;

use App\Models\Notice;
use Carbon\Carbon;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
use Illuminate\Support\Facades\DB;

class NoticeController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Notice(), function (Grid $grid) {
            $roleIds = Admin::user()->roles->pluck('id');
            $grid->model()->whereIn('admin_role_id',$roleIds);
            $grid->column('id')->sortable();
            $grid->column('notice_name');
            $grid->column('admin_role_id');
            $grid->column('file_path');
            $grid->column('user_id');
            $grid->column('created_date');
            $grid->column('modify_date');
            $grid->column('deleted_date');
            $grid->column('notice_no');
            $grid->column('expired_date');
            $grid->column('first_path');

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');

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
        return Show::make($id, new Notice(), function (Show $show) {
            $show->field('id');
            $show->field('notice_name');
            $show->field('dept');
            $show->field('file_path');
            $show->field('user_id');
            $show->field('created_date');
            $show->field('modify_date');
            $show->field('deleted_date');
            $show->field('notice_no');
            $show->field('expired_date');
            $show->field('first_path');
        });
    }

    /**
     * Make a forms builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Notice(), function (Form $form) {
            $roles = Admin::user()->roles->pluck('name','id');
//            $forms->display('id');

            if ($form->isCreating()) {
                $form->hidden('notice_no');
            }

            if ($form->isEditing()) {
                $form->display('notice_no');
            }

            $form->text('notice_name')->required();
            $form->select('admin_role_id')->options($roles)->required();
            $form->file('file_path')
                ->disk('notice')
                ->accept('xls,xlsx,csv,pdf')
                ->uniqueName()
                ->autoUpload();
//            $forms->text('user_id');

            if ($form->isCreating()) {
                $form->hidden('created_date');
                $form->hidden('modify_date');
                $form->hidden('deleted_date');
            }

            if ($form->isEditing()) {
                $form->display('created_date');
                $form->display('modify_date');
                $form->display('deleted_date');
            }

//            $forms->text('notice_no');
            $form->date('expired_date');
            $form->text('first_path');

            $form->submitted(function (Form $form) {
                $now = Carbon::now()->toDateString();

                // 判断是否是新增操作
                if ($form->isCreating()) {
                    $form->input('created_date', $now);
                    $notice_no = DB::table('notices')->max('notice_no');
                    //最小編號10001
                    if($notice_no <= 10000){
                        $notice_no = 10001;
                    }else{
                        $notice_no++ ;
                    }
                    $form->input('notice_no', $notice_no);
                }

                $form->input('modify_date', $now);

                if($form->expired_date == ''){
                    $form->input('expired_date', '9999-12-31');
                }

            });
        });
    }
}
