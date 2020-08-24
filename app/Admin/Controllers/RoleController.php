<?php

namespace App\Admin\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\User;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\IFrameGrid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;


class RoleController extends AdminController
{
    protected function iFrameGrid()
    {
        $grid = new IFrameGrid(new Role());
        $grid->model()->with('permissions');

        // 表格快捷搜索
        $grid->quickSearch('name')
            ->placeholder('輸入「名稱」快速搜索');

        // 指定行选择器选中时显示的值的字段名称
        // 如果表格数据中带有 “name”、“title”或“username”字段，则可以不用设置
        $grid->rowSelector()->titleColumn('name');

        $grid->name->label();
        $grid->permissions()->pluck('name')->label('danger');

        return $grid;
    }


    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Role(), function (Grid $grid) {
            $grid->showQuickEditButton();

            $grid->model()->with('users')->with('permissions');

//            $grid->id->sortable();
            $grid->name->label();
            $grid->guard_name;
            $grid->permissions()->pluck('name')->label('danger');
            $grid->users->display('用戶')->expand(function () {
                // 允许在比包内返回异步加载类的实例
                return \App\Admin\Renderable\User::make(['id' => $this->id]);
            });
            $grid->created_at;
            $grid->updated_at->sortable();

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
        return Show::make($id, new Role(), function (Show $show) {
            $show->id;
            $show->name;
            $show->guard_name;
            $show->created_at;
            $show->updated_at;
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $role = Role::with('permissions')->with('users');
        return  Form::make($role, function (Form $form) {
            $form->display('id');
            $form->text('name');
            $form->text('guard_name');

            //選擇權限(樹狀插件)
            $form->tree('permissions')
                ->nodes(function () {
                    return (new Permission())->allNodes();
                })
                ->customFormat(function ($v) {
                    if (!$v) return [];

                    // 这一步非常重要，需要把数据库中查出来的二维数组转化成一维数组
                    return array_column($v, 'id');
                });

            //選擇用戶
            $form->selectResource('users')
                ->path('pages/front_users') // 设置表格页面链接
                ->multiple() // 设置为多选
                ->options(function () { // 显示已选中的数据

                    $v = User::all()->pluck('txt_name','id')->toArray();

                    return $v;
                })->customFormat(function ($v) {
                    if (!$v) return [];
                    return array_column($v, 'id');
                })
            ;

            $form->display('created_at');
            $form->display('updated_at');

            //保存完後刷新權限
            $form->saved(function (Form $form, $result) {
                $user = new User();
                $user->syncPermissions([]);
            });
        });
    }
}
