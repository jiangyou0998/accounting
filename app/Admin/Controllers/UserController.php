<?php

namespace App\Admin\Controllers;



use App\Models\Role;
use App\User;
use Dcat\Admin\Form;
use Dcat\Admin\Models\Administrator;
use Dcat\Admin\IFrameGrid;
use Dcat\Admin\Grid;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Show;

class UserController extends AdminController
{
    protected function iFrameGrid()
    {
        $grid = new IFrameGrid(new User());

        // 表格快捷搜索
        $grid->quickSearch('name','txt_name')
            ->placeholder('輸入「登錄名」或「名稱」快速搜索');

        // 指定行选择器选中时显示的值的字段名称
        // 如果表格数据中带有 “name”、“title”或“username”字段，则可以不用设置
        $grid->rowSelector()->titleColumn('txt_name');

        $grid->id->sortable();
        $grid->name;
        $grid->txt_name;

        return $grid;
    }

    protected function grid()
    {
        return Grid::make(new User(), function (Grid $grid) {
            $grid->showQuickEditButton();
            $grid->model()->with('roles');

            $grid->id->sortable();
            $grid->name;
            $grid->roles()->pluck('name')->label();
            $grid->txt_name;
            $grid->email;
            $grid->chr_report_name;
            $grid->int_dept;
            $grid->int_district;

            $grid->chr_type;



            $grid->chr_pocode;
            $grid->int_sort;

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');

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
        $user = User::with('roles');
        return Form::make($user, function (Form $form) {
            $form->display('id');
            $form->text('name')->required()->rules("required|
                unique:users,name,{$form->getKey()},id", [
                'unique'   => '用戶名已存在',
            ]);
//            $form->text('password');
            $form->text('txt_name');
            $form->text('chr_report_name');
            $form->text('int_dept');

            $form->text('email');
            $form->text('chr_type');


            $form->text('chr_ename');




            $form->text('chr_pocode');
            $form->text('int_sort');

            //選擇角色
            $form->selectResource('roles')
                ->path('front/roles') // 设置表格页面链接
                ->multiple() // 设置为多选
                ->options(function () { // 显示已选中的数据

                    $v = Role::all()->pluck('name','id')->toArray();
//                    dump($v);

                    return $v;
                })->customFormat(function ($v) {
                    if (!$v) return [];
                    return array_column($v, 'id');
                })
            ;

            //保存完後刷新權限
            $form->saved(function (Form $form, $result) {
                $user = new \App\User();
                $user->syncPermissions([]);
            });
        });
    }
}
