<?php

namespace App\Models\Supplier;


use App\Models\SupplierGroup;
use App\Models\SupplierStockItem;
use App\Models\WorkshopUnit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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

    public function stock_items()
    {
        return $this->hasMany(SupplierStockItem::class,"product_id","id");
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

    public function scopeOfSupplier($query, $supplier)
    {
        if ($supplier) {
            return $query->where('supplier_id', $supplier);
        }else{
            return $query;
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

    public function scopeOfType($query, $type, $month)
    {
        switch ($type){
            //已填寫
            case 'filled':
                return $query->where(function($query) use($month){
                    $query->whereHas('stock_items',function ($query) use($month){
                        $query->where('month', $month)
                            ->where('user_id', Auth::id());
                    });
                });
            //未填寫
            case 'empty':
                return $query->where(function($query) use($month){
                    $query->whereDoesntHave('stock_items',function ($query) use($month){
                        $query->where('month', $month)
                            ->where('user_id', Auth::id());
                    });
                });

            default :
                return $query;
        }

    }

    public static function getProducts($ids = null, $group = null, $supplier = null, $search = null, $type = null, $month = null){

        $products = self::with(['unit', 'base_unit'])
            ->ofIds($ids)
            ->OfGroup($group)
            ->OfSupplier($supplier)
            ->OfSearch($search)
            ->OfType($type, $month)
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
