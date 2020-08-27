<?php

namespace App\Admin\Renderable;

use App\Models\TblUser;
use Dcat\Admin\Grid;
use Dcat\Admin\Grid\LazyRenderable;
use Dcat\Admin\Models\Administrator;

class KBShopTable extends LazyRenderable
{
    public function grid(): Grid
    {
        // 获取外部传递的参数
        $id = $this->int_id;

        return Grid::make(new TblUser(), function (Grid $grid) {
            $grid->model()->where('chr_type','=',2)
                ->where(function($query) {
                    $query->where('txt_login','like','kb%')
                        ->orWhere('txt_login','like','ces%')
                        ->orWhere('txt_login','like','b&b%');
                })
                ->orderBy('txt_login');

            $grid->column('txt_login',"登入名");
            $grid->column('txt_name',"名稱");

            // 指定行选择器选中时显示的值的字段名称
            // 指定行选择器选中时显示的值的字段名称
            // 指定行选择器选中时显示的值的字段名称
            // 如果表格数据中带有 “name”、“title”或“username”字段，则可以不用设置
            $grid->rowSelector()->titleColumn('txt_name');

            $grid->quickSearch(['txt_login','txt_name']);

            $grid->paginate(10);
            $grid->disableActions();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->like('txt_login',"登入名")->width(4);
                $filter->like('txt_name',"名稱")->width(4);
            });
        });
    }
}
