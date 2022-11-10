<?php

namespace App\Admin\Renderable;

use App\Models\WarehouseProductPrice;
use App\User;
use Dcat\Admin\Grid;
use Dcat\Admin\Grid\LazyRenderable;

class WarehouseProductPriceTable extends LazyRenderable
{
    public function grid(): Grid
    {
        // 获取外部传递的参数
        $id = $this->key;

        return Grid::make(new WarehouseProductPrice(), function (Grid $grid) use($id){
            $grid->model()
                ->with('product')
                ->where('product_id', $id)
                ->latest('start_date');

            $grid->column('id', 'ID')->sortable();
            $grid->column('product.product_name', '產品名稱')->limit(20);
            $grid->column('price', '價格');
            $grid->column('base_price', '來貨價');
            $grid->column('start_date', '開始生效時間');
            $grid->column('end_date', '最後生效時間');

            $grid->paginate(10);
            $grid->disableActions();
            $grid->disableFilter();
            $grid->disableRowSelector();
        });
    }
}
