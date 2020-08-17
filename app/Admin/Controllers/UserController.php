<?php

namespace App\Admin\Controllers;


use App\Admin\Repositories\User;
use Dcat\Admin\Models\Administrator;
use Dcat\Admin\IFrameGrid;
use Dcat\Admin\Grid;
use Dcat\Admin\Controllers\AdminController;

class UserController extends AdminController
{
    protected function iFrameGrid()
    {
        $grid = new IFrameGrid(new User());

        // 表格快捷搜索
        $grid->quickSearch('name','txt_name')
            ->placeholder('輸入「登錄名」或「名稱」快速搜索');

        // 指定行选择器选中时显示的值的字段名称
        // 指定行选择器选中时显示的值的字段名称
        // 指定行选择器选中时显示的值的字段名称
        // 如果表格数据中带有 “name”、“title”或“username”字段，则可以不用设置
        $grid->rowSelector()->titleColumn('name');

        $grid->id->sortable();
        $grid->name;
        $grid->txt_name;

        $grid->filter(function (Grid\Filter $filter) {
            $filter->equal('id');
//            $filter->like('name');
//            $filter->like('txt_name');
        });

        return $grid;
    }
}
