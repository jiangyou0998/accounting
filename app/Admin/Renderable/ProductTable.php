<?php

namespace App\Admin\Renderable;

use App\Models\WorkshopProduct;
use Dcat\Admin\Grid;
use Dcat\Admin\Grid\LazyRenderable;

class ProductTable extends LazyRenderable
{
    public function grid(): Grid
    {
        // 获取外部传递的参数
        $id = $this->id;

        return Grid::make(new WorkshopProduct(), function (Grid $grid) {
            $grid->model()->where('status','!=' , 4);

            $grid->column('product_no','編號');
            $grid->column('product_name','產品名');

            // 指定行选择器选中时显示的值的字段名称
            // 指定行选择器选中时显示的值的字段名称
            // 指定行选择器选中时显示的值的字段名称
            // 如果表格数据中带有 “name”、“title”或“username”字段，则可以不用设置
            $grid->rowSelector()->titleColumn('product_name');

            $grid->quickSearch(['product_no' , 'product_name']);

            $grid->paginate(10);
            $grid->disableActions();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->like('product_no','編號')->width(4);
                $filter->like('product_name','產品名')->width(4);
            });
        });
    }
}
