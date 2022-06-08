<?php

namespace App\Observers;

use App\Models\Supplier\Supplier;
use App\Models\WarehouseProduct;
use App\Models\WarehouseStockItem;
use Illuminate\Support\Facades\DB;

class WarehouseStockItemObserver
{
    public function created(WarehouseStockItem $stock_item)
    {
        $product_id = $stock_item->product_id;

        $supplier_id = WarehouseProduct::find($product_id)->supplier_id ?? 0;

        DB::table('suppliers')
            ->where('id', $supplier_id)
            ->increment('warehouse_used_count');
    }

}
