<?php

namespace App\Models;


use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class WarehouseStockItem extends Model
{
    const TAB_SHOW_DATE = 30;

    protected $table = 'warehouse_stock_items';
    public $timestamps = false;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function product()
    {
        return $this->belongsTo(WarehouseProduct::class,'product_id','id');
    }

    public function unit()
    {
        return $this->belongsTo(WorkshopUnit::class,'unit_id','id');
    }

    public function scopeOfTimes($query, $times)
    {
        if ($times) {
            return $query->where('times', $times);
        }else{
            return $query->whereNull('times');
        }
    }

    //獲取最大的Times
    public static function getMaxTimes($shop_id)
    {
        return self::query()
            ->where('user_id', $shop_id)
            ->max('times');
    }

    //獲取頂部最近Invoice Tab
    public static function getInvoiceTab(){
        $warehouse_stock_items = WarehouseStockItem::query()
            ->with('product')
            ->whereBetween(DB::raw("date(`date`)"), [Carbon::now()->subDay(self::TAB_SHOW_DATE), Carbon::now()])
            ->whereNotNull('times')
            ->orderBy('date')
            ->get();

        $tabs = array();
        foreach ($warehouse_stock_items as $item){
            $date_string = Carbon::parse((string)$item->date)->toDateString();
            $tabs[$item->product->supplier_id][$date_string][$item->times] = ['times' => $item->times, 'invoice_no' => $item->invoice_no];
        }

        return $tabs;

    }

}
