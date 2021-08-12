<?php

namespace App\Models\Supplier;


use App\Models\SupplierGroup;
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

    public function scopeOfIds($query, $ids = null)
    {
        if($ids){
            return $query->whereIn('id', $ids);
        }else{
            return $query;
        }

    }

    public static function getProducts($ids = null){
        $products = SupplierProduct::with(['unit', 'base_unit'])
            ->ofIds($ids)
            ->where('status', 0)
            ->orderBy('supplier_id')
            ->orderBy('group_id')
            ->get()
            ->groupBy('supplier_id');

        $products->transform(function ($item, $key) {
            return $item->groupBy('group_id');
        });

        return $products;
    }

}
