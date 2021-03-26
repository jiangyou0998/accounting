<?php

namespace App\Admin\Renderable;

use App\User;
use Dcat\Admin\Grid;
use Dcat\Admin\Grid\LazyRenderable;

class CustomerShopTable extends LazyRenderable
{
    public function grid(): Grid
    {
        // 获取外部传递的参数
        $id = $this->id;

        return Grid::make(new User(), function (Grid $grid) {
            $grid->model()
                ->whereHas('shop_groups', function ($query){
                    $query->whereNotIn('id', [1,5]);
                })
                ->orderBy('name');

            $grid->column('name',"登入名");
            $grid->column('txt_name',"名稱");

            // 指定行选择器选中时显示的值的字段名称
            // 指定行选择器选中时显示的值的字段名称
            // 指定行选择器选中时显示的值的字段名称
            // 如果表格数据中带有 “name”、“title”或“username”字段，则可以不用设置
            $grid->rowSelector()->titleColumn('txt_name');

            $grid->quickSearch(['name','txt_name']);

            $grid->paginate(10);
            $grid->disableActions();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->like('name',"登入名")->width(4);
                $filter->like('txt_name',"名稱")->width(4);
            });
        });
    }
}
