<?php

namespace App\Admin\Controllers;

use App\Models\Notice;
use App\Models\Role;
use Carbon\Carbon;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Widgets\Alert;
use Illuminate\Support\Facades\DB;

class NoticeController extends AdminController
{
    protected $options = [
        0 => '單文件',
        1 => '多文件',
    ];
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Notice(), function (Grid $grid) {
//            dump(!Admin::user()->isAdministrator());
            $roleIds = Admin::user()->roles->pluck('id');
            $grid->column('notice_no')->sortable();
            $grid->model()
                ->with('roles')
                ->with('users')
                ->orderByDesc('updated_at');

            //2020-12-30 非管理員只加載所在的role組通告
            if(!Admin::user()->isAdministrator()){
                $grid->model()->whereIn('admin_role_id',$roleIds);
            }

//            $grid->column('id')->sortable();
            $grid->column('notice_name')->limit(20);
            $grid->column('roles.name','部門');
            $grid->column('users.name','操作人');
//            dump($this->is_directory);
            $grid->column('file_path')->display(function ($file_path) {
                return '<a href="/notices/' . $file_path . '" target="_blank">查看</a>';
            });
            $grid->column('first_path')->display(function ($first_path) {
                return '<a href="http://' . $first_path . '" target="_blank">' . $first_path . '</a>';
            });
            $grid->column('created_at')->hide();
            $grid->column('updated_at')->sortable();
//            $grid->column('deleted_date');
            $grid->column('expired_date');

            //2020-12-30 篩選器
            $grid->filter(function (Grid\Filter $filter) {
                $filter->like('notice_name');
                $filter->like('roles.name','部門');
                $filter->like('users.name','操作人');

            });

            //2020-12-30 過期選擇器
            $grid->selector(function (Grid\Tools\Selector $selector) {

                $selector->selectOne('expired_date', '是否過期', [
                    0 => '過期',
                    1 => '未過期',
                ], function ($query, $value) {

                    $now = Carbon::now()->toDateString();

                    if ($value == 0) {
                        $query->where('expired_date', '<', $now);
                    } else if ($value == 1) {
                        $query->where('expired_date', '>=', $now);
                    }

                });


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
//            $show->field('created_date');
//            $show->field('modify_date');
//            $show->field('deleted_date');
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
        $builder = new Notice();
        $builder = $builder->with('attachments');

        return Form::make($builder, function (Form $form) {
            $roles = Admin::user()->roles->pluck('name','id');
//            $forms->display('id');
            //2020-12-29 管理員顯示所有部門
            if(Admin::user()->isAdministrator()){
                $roleModel = config('admin.database.roles_model');
                $roles = $roleModel::all()->pluck('name','id');
            }

            if ($form->isCreating()) {
                $form->hidden('notice_no');
            }

            if ($form->isEditing()) {
                $form->display('notice_no');
            }

            $form->hidden('user_id');

            $form->text('notice_name')->required();
            $form->select('admin_role_id')->options($roles)->required();

            if ($form->isCreating()) {
                $form->hidden('created_at');
                $form->hidden('updated_at');
                $form->hidden('deleted_at');
            }

            if ($form->isEditing()) {
                $form->display('created_at');
                $form->display('updated_at');
                $form->display('deleted_at');
            }

//            $forms->text('notice_no');
            $form->date('expired_date');
            $form->text('first_path');

            $alertText = '僅支持 xls, xlsx, csv, pdf, mp4, mov, jpg, jpeg, png文件上傳，最大支持200M的文件！';
            $form->html(Alert::make($alertText, '提示')->info());
            $form->radio('is_directory','文件數量')
                ->when([0, 1], function (Form $form) {

                })
                ->when(0, function (Form $form) {
                    //單文件
                    $form->file('file_path')
                        ->disk('notice')
                        ->accept('xls,xlsx,csv,pdf,mp4,mov,jpg,jpeg,png')
                        ->uniqueName()
                        ->maxSize(204800)
                        ->autoUpload();
                })
                ->when(1, function (Form $form) {
                    //多文件
                    //2021-01-19 attachment多個文件
                    $form->hasMany('attachments','多文件', function (Form\NestedForm $form) {
                        $form->text('title','標題');
                        $form->file('file_path')
                            ->disk('notice')
                            ->accept('xls,xlsx,csv,pdf,mp4,mov,jpg,jpeg,png')
                            ->uniqueName()
                            ->maxSize(204800)
                            ->autoUpload();
                    });
                })
                ->options($this->options)
                ->default(0);

            $form->submitted(function (Form $form) {
                $now = Carbon::now()->toDateTimeString();

                // 判断是否是新增操作
                if ($form->isCreating()) {
                    $form->input('created_at', $now);
                    $notice_no = DB::table('notices')->max('notice_no');
                    //最小編號10001
                    if($notice_no <= 10000){
                        $notice_no = 10001;
                    }else{
                        $notice_no++ ;
                    }
                    $form->input('notice_no', $notice_no);
                }

                $form->input('user_id', Admin::user()->id);
                $form->input('updated_at', $now);

                if($form->expired_date == ''){
                    $form->input('expired_date', '9999-12-31');
                }

            });
        });
    }
}
