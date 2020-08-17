<?php

namespace App\Admin\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\User;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
use Illuminate\Support\Collection;

class RoleController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Role(), function (Grid $grid) {
            $grid->showQuickEditButton();

            $grid->id->sortable();
            $grid->name->label('danger');;
            $grid->guard_name;
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

            $form->tree('permissions')
                ->nodes(function () {
                    return (new Permission())->allNodes();
                })
                ->customFormat(function ($v) {
                    if (!$v) return [];

                    // 这一步非常重要，需要把数据库中查出来的二维数组转化成一维数组
                    return array_column($v, 'id');
                });

//            $form->tree('users')
//                ->nodes(function () {
//                    return (new User())->allNodes();
//                })
//                ->customFormat(function ($v) {
//                    if (!$v) return [];
//
//                    // 这一步非常重要，需要把数据库中查出来的二维数组转化成一维数组
//                    return array_column($v, 'id');
//                });

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

//            $form->saving(function (Form $form) {
//                dump($form->users);
//
//                $form->model()->collection(function (Collection $collection) {
//
//
////                $collection->transform(function ($item) {
////
////                    return $item;
////                });
//
//                    //给表格加一个序号列
//                    $collection->transform(function ($item, $index) {
//                        dump($item['users']);
////                        $item['users'] = $index + 1 ;
//
//                        return $item;
//                    });
//
//                    // 最后一定要返回集合对象
//                    return $collection;
//                });
////                dump($form->getKey());
//            });

            $form->saved(function (Form $form, $result) {
                $user = new User();
                $user->syncPermissions([]);
            });
        });
    }
}
