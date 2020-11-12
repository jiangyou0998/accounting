<?php

namespace App\Admin\Controllers;

use App\Models\ShopGroup;
use App\User;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class ShopGroupController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new ShopGroup(), function (Grid $grid) {
            $grid->id->sortable();
            $grid->name;
            $grid->sort;
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
        return Show::make($id, new ShopGroup(), function (Show $show) {
            $show->id;
            $show->name;
            $show->sort;
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
        $shop_group = ShopGroup::with('users');
        return Form::make($shop_group, function (Form $form) {
            $form->display('id');
            $form->text('name');
            $form->text('sort');

            $form->display('created_at');
            $form->display('updated_at');

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
        });
    }
}
