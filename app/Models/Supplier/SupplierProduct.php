<?php

namespace App\Models\Supplier;


use App\Models\WorkshopUnit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SupplierProduct extends Model
{

    protected $table = 'supplier_products';
    protected $guarded = [];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class,"supplier_id","id");
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
