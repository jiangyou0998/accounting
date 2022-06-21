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

    public function warehouse_group()
    {
        return $this->belongsTo(WarehouseGroup::class,"warehouse_group_id","id");
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

    public static function getProducts($ids = null, $warehouse_group = null, $supplier = null, $search = null, $type = null, $times = null){

        $products = self::with(['unit', 'base_unit'])
            ->ofIds($ids)
            ->OfWarehouseGroup($warehouse_group)
            ->OfSupplier($supplier)
            ->OfSearch($search)
            ->OfType($type)
            ->ofTimes($times)
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
        }else{
            return $query;
        }
    }

    public function scopeOfWarehouseGroup($query, $warehouse_group)
    {
        if ($warehouse_group) {
            return $query->where('warehouse_group_id', $warehouse_group);
        }else{
            return $query;
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
        }else{
            return $query;
        }
    }

    public function scopeOfType($query, $type)
    {
        switch ($type){
            //已填寫
            case 'filled':
                return $query->where(function($query) use($type){
                    $query->whereHas('stock_items',function ($query){
                        $query->where('user_id', Auth::id());
                    });
                });
            //未填寫
            case 'empty':
                return $query->where(function($query) use($type){
                    $query->whereDoesntHave('stock_items',function ($query){
                        $query->where('user_id', Auth::id());
                    });
                });

            default :
                return $query;
        }

    }

//    public function scopeOfTimes($query, $times = null)
//    {
//        if ($times === null) {
//            return $query;
//        }
//
//        if($times > 0){
//            return $query->where(function ($query) use ($times) {
//                $query->whereHas('stock_items', function ($query) use ($times) {
//                    $query->where('times', $times)
//                        ->where('user_id', Auth::id());
//                });
//            });
//        }else{
//            return $query->where(function ($query){
//                $query->whereHas('stock_items', function ($query){
//                    $query->whereNull('times')
//                        ->where('user_id', Auth::id());
//                });
//            });
//        }
//    }

    public function scopeOfTimes($query, $times = null)
    {
        if ($times === null) {

            $product_id = WarehouseStockItem::query()
                ->where('user_id', Auth::id())
                ->whereNull('times')
                ->first()->product_id ?? '';

            //如一個都無填, 獲取所有產品
            if($product_id === ''){
                return $query;
            }

            $supplier_id = WarehouseProduct::find($product_id)->supplier_id;

            return $query->where('supplier_id', $supplier_id);
        }

        if($times > 0){

            $product_id = WarehouseStockItem::query()
                ->where('user_id', Auth::id())
                ->where('times',$times)
                ->first()->product_id ?? '';

            //如一個都無填, 獲取所有產品
            if($product_id === ''){
                return $query;
            }

            $supplier_id = WarehouseProduct::find($product_id)->supplier_id;

            return $query->where('supplier_id', $supplier_id);

        }
    }
}
