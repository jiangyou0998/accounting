<?php

namespace App\Models;


use App\Models\Supplier\Supplier;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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

    public function stock_items()
    {
        return $this->hasMany(WarehouseStockItem::class,"product_id","id");
    }

    public static function getProducts($ids = null, $warehouse_group = null, $supplier = null, $search = null, $type = null, $date = null){
        $date = Carbon::parse($date)->isoFormat('YMMDD');
        $products = self::with(['unit', 'base_unit'])
            ->ofIds($ids)
            ->OfWarehouseGroup($warehouse_group)
            ->OfSupplier($supplier)
            ->OfSearch($search)
            ->OfType($type, $date)
            ->where('status', 0)
            ->orderBy('supplier_id')
            ->orderBy('warehouse_group_id')
            ->get()
            ->groupBy('supplier_id');

        $products->transform(function ($item, $key) {
            return $item->groupBy('warehouse_group_id');
        });

        return $products;
    }

    public function scopeOfIds($query, $ids = null)
    {
        if($ids){
            return $query->whereIn('id', $ids);
        }else{
            return $query;
        }

    }

    public function scopeOfGroup($query, $group)
    {
        if ($group) {
            return $query->where('group_id', $group);
        }
    }

    public function scopeOfWarehouseGroup($query, $warehouse_group)
    {
        if ($warehouse_group) {
            return $query->where('warehouse_group_id', $warehouse_group);
        }
    }

    public function scopeOfSupplier($query, $supplier)
    {
        if ($supplier) {
            return $query->where('supplier_id', $supplier);
        }
    }

    public function scopeOfSearch($query, $search)
    {
        if ($search) {
            return $query->where(function($query) use($search){
                $query->where('product_name', 'like', "%$search%")
                    ->orWhere('product_name_short', 'like', "%$search%")
                    ->orWhere('product_no', 'like', "%$search%");
            });
        }
    }

    public function scopeOfType($query, $type, $date)
    {
        switch ($type){
            //已填寫
            case 'filled':
                return $query->where(function($query) use($type, $date){
                    $query->whereHas('stock_items',function ($query) use($date){
                        $query->where('date', $date)
                            ->where('user_id', Auth::id());
                    });
                });
            //未填寫
            case 'empty':
                return $query->where(function($query) use($type, $date){
                    $query->whereDoesntHave('stock_items',function ($query) use($date){
                        $query->where('date', $date)
                            ->where('user_id', Auth::id());
                    });
                });

            default :
                return $query;
        }

    }

}
