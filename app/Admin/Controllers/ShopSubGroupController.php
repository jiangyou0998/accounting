<?php

namespace App\Admin\Controllers;

use App\Models\ShopGroup;
use App\Models\ShopSubGroup;
use App\User;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\IFrameGrid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class ShopSubGroupController extends AdminController
{
    protected function iFrameGrid()
    {
        $grid = new IFrameGrid(new ShopSubGroup());
//        $grid->model()->with('permissions');

        // 表格快捷搜索
        $grid->quickSearch('name')
            ->placeholder('輸入「名稱」快速搜索');

        // 指定行选择器选中时显示的值的字段名称
        // 如果表格数据中带有 “name”、“title”或“username”字段，则可以不用设置
        $grid->rowSelector()->titleColumn('name');

        $grid->name;

        return $grid;
    }
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new ShopSubGroup(), function (Grid $grid) {

            //2021-03-18 禁用詳情、刪除按鈕
            $grid->disableViewButton();
            $grid->disableDeleteButton();

            $grid->model()->with('shop_group');

            $grid->id->sortable();
            $grid->name;
            $grid->sort;
            $grid->column('shop_group.name', '上級分組');
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
        return Show::make($id, new ShopSubGroup(), function (Show $show) {
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
        $shop_group = ShopSubGroup::with('users');
        return Form::make($shop_group, function (Form $form) {

            $form->tools(function (Form\Tools $tools) {
                // 去掉跳转列表按钮
//                $tools->disableList();
                // 去掉跳转详情页按钮
                $tools->disableView();
                // 去掉删除按钮
                $tools->disableDelete();

                // 添加一个按钮, 参数可以是字符串, 匿名函数, 或者实现了Renderable或Htmlable接口的对象实例
//                $tools->append('<a class="btn btn-sm btn-danger"><i class="fa fa-trash"></i>&nbsp;&nbsp;delete</a>');
            });

            $form->display('id');
            $form->text('name')->required();
            $form->number('sort','排序')->required();
            $form->select('shop_group_id', '上級分組')
                ->options(ShopGroup::all()->pluck('name', 'id'))
                ->required();

            $form->display('created_at');
            $form->display('updated_at');

            //選擇用戶
            $form->selectResource('users', '分店')
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
