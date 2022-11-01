<?php

namespace App\Admin\Renderable;

use App\Models\Role;
use App\Models\ShopGroup;
use App\User;
use Dcat\Admin\Grid;
use Dcat\Admin\Grid\LazyRenderable;

class FrontUserTable extends LazyRenderable
{
    public function grid(): Grid
    {
        // 获取外部传递的参数
        $roles = $this->roles;

        return Grid::make(new User(), function (Grid $grid) use($roles){

            $grid->model()
                ->whereHas('roles', function ($query) use($roles){
                    $query->where('name', $roles);
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
