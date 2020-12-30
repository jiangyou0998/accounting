<?php

namespace App\Admin\Controllers;

use App\Models\Form as FormModel;
use Carbon\Carbon;
use Dcat\Admin\Admin;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;

class FormController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new FormModel(), function (Grid $grid) {
            $roleIds = Admin::user()->roles->pluck('id');
            $grid->model()
                ->with('roles')
                ->with('users')
                ->orderByDesc('modify_date');

            //2020-12-30 非管理員只加載所在的role組表格
            if(!Admin::user()->isAdministrator()){
                $grid->model()->whereIn('admin_role_id',$roleIds);
            }
//            $grid->column('id')->sortable();
            $grid->column('form_no');
            $grid->column('form_name')->limit(20);
            $grid->column('roles.name','部門');
            $grid->column('users.name','操作人');
            $grid->column('file_path')->display(function ($file_path) {
                return '<a href="/forms/' . $file_path . '" target="_blank">' . $file_path . '</a>';
            });
            $grid->column('sample_path')->display(function ($sample_path) {
                return '<a href="/forms/' . $sample_path . '" target="_blank">' . $sample_path . '</a>';
            });
            $grid->column('first_path');
            $grid->column('created_date')->hide();
            $grid->column('modify_date');
//            $grid->column('deleted_date');

            //2020-12-30 篩選器
            $grid->filter(function (Grid\Filter $filter) {
                $filter->like('form_name');
                $filter->like('roles.name','部門');
                $filter->like('users.name','操作人');

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
        return Show::make($id, new FormModel(), function (Show $show) {
            $show->field('id');
            $show->field('form_name');
            $show->field('admin_role_id');
            $show->field('file_path');
            $show->field('user_id');
            $show->field('created_date');
            $show->field('modify_date');
            $show->field('deleted_date');
            $show->field('form_no');
            $show->field('is_sample');
            $show->field('sample_path');
            $show->field('first_path');
            $show->field('is_multi_print');
        });
    }

    /**
     * Make a forms builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new FormModel(), function (Form $form) {
            $roles = Admin::user()->roles->pluck('name','id');
//            $forms->display('id');

//            if ($form->isCreating()) {
//                $form->hidden('form_no');
//            }
//
//            if ($form->isEditing()) {
//                $form->display('form_no');
//            }

            $form->text('form_no')->required();

            $form->hidden('user_id');

            $form->text('form_name')->required();
            $form->select('admin_role_id')->options($roles)->required();
            $form->file('file_path')
                ->disk('forms')
                ->accept('xls,xlsx,csv,pdf')
                ->uniqueName()
                ->autoUpload();

            $form->file('sample_path')
                ->disk('forms')
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
            $form->text('first_path');

            $form->submitted(function (Form $form) {
                $now = Carbon::now()->toDateString();

                // 判断是否是新增操作
                if ($form->isCreating()) {
                    $form->input('created_date', $now);
//                    $notice_no = DB::table('notices')->max('notice_no');
//                    //最小編號10001
//                    if($notice_no <= 10000){
//                        $notice_no = 10001;
//                    }else{
//                        $notice_no++ ;
//                    }
//                    $form->input('notice_no', $notice_no);
                }

                $form->input('user_id', Admin::user()->id);
                $form->input('modify_date', $now);

                if($form->expired_date == ''){
                    $form->input('expired_date', '9999-12-31');
                }

            });
        });
    }
}
