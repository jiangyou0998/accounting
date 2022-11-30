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
        $product_id = $this->key;

        return Grid::make(new WarehouseProductPrice(), function (Grid $grid) use($product_id){
            $grid->model()
                ->with('product')
                ->where('product_id', $product_id)
                ->latest('start_date');

            //新增按鈕
            $createButtonUrl = route('warehouse.product.price.create', ['product_id' => $product_id]);
            $createButtonHtml = <<<HTML
    <a href="{$createButtonUrl}" target="_blank" class="btn btn-primary btn-outline pull-right">
    <i class="feather icon-plus"></i><span class="d-none d-sm-inline">&nbsp;&nbsp;新增</span>
</a>
HTML;
            $grid->tools($createButtonHtml);

            //查看按鈕
            $searchButtonUrl = route('warehouse.product.price.index', ['product_id' => $product_id]);
            $searchButtonUrl = <<<HTML
    <a href="{$searchButtonUrl}" target="_blank" class="btn btn-primary btn-outline pull-right">
    <i class="feather icon-zoom-in"></i><span class="d-none d-sm-inline">&nbsp;&nbsp;查看</span>
</a>
HTML;
            $grid->tools($searchButtonUrl);

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
