<?php

namespace App\Models;


use App\Models\Supplier\Supplier;
use Illuminate\Database\Eloquent\Model;

class WarehouseProduct extends Model
{

    protected $table = 'warehouse_products';

    public function supplier()
    {
        return $this->belongsTo(Supplier::class,"supplier_id","id");
    }

    public function supplier_group()
    {
        return $this->belongsTo(SupplierGroup::class,"group_id","id");
    }

    public function unit()
    {
        return $this->belongsTo(WorkshopUnit::class,"unit_id","id");
    }

    public function base_unit()
    {
        return $this->belongsTo(WorkshopUnit::class,"base_unit_id","id");
    }

}
