<?php

namespace App\Admin\Controllers;

use App\Models\Role;
use App\User;
use Dcat\Admin\Form;
use Dcat\Admin\IFrameGrid;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Hash;

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
            $grid->txt_name;
            $grid->report_name;
            $grid->roles()->pluck('name')->label();
            $grid->email;

            $grid->filter(function (Grid\Filter $filter) {
                $rolesModel = config('front.database.roles_model');
                $roles = $rolesModel::all()->pluck('name','name');
                $filter->equal('roles.name','角色')->select($roles);

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
        $user = User::with('roles')
            ->with('address');
        return Form::make($user, function (Form $form) {
            $form->display('id');
            $id = $form->getKey();
//            dump(User::find($id)->can('shop'));
            $form->text('name')->required()->rules("required|
                unique:users,name,{$form->getKey()},id", [
                'unique'   => '用戶名已存在',
            ]);
//            $form->text('password');
            $form->text('txt_name');
            $form->text('report_name');
//            $form->text('int_dept');
            $form->password('password','新密碼');
            // 设置错误信息
            $form->password('password_confirm','確認密碼')->same('password', '两次密码输入不一致');

            $form->email('email');


            if ($form->isEditing()) {
                if (User::find($id)->can('shop')){
                    $form->divider();
                    $form->text('address.shop_name','分店名');
                    $form->text('address.address','地址');
                    $form->text('address.eng_address','英文地址');
                    $form->text('address.tel','電話');
                    $form->text('address.fax','FAX');
                    $form->text('address.oper_time','營業時間');
                    $form->divider();
                }

            }

//            $form->text('int_sort');

            //選擇角色
            $form->selectResource('roles')
                ->path('front/roles') // 设置表格页面链接
//                ->multiple() // 设置为多选
                ->options(function () { // 显示已选中的数据

                    $v = Role::all()->pluck('name','id')->toArray();
//                    dump($v);

                    return $v;
                })->customFormat(function ($v) {
                    if (!$v) return [];
                    return array_column($v, 'id');
                });

            $form->saving(function (Form $form) {
                // 判断是否是新增操作
                if ($form->isCreating()) {

                }

                $password = $form->input('password');
                if ($password){
                    // 加密
                    $form->input('password', Hash::make($password));
                }else{
                    $form->deleteInput('password');
                }

                // 删除用户提交的数据
                $form->deleteInput('password_confirm');

            });


            //保存完後刷新權限
            $form->saved(function (Form $form, $result) {
                $user = new \App\User();
                $user->syncPermissions([]);
            });
        });
    }
}
