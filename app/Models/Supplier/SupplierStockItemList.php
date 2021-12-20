<?php

namespace App\Models\Supplier;


use App\Models\FrontGroup;
use Illuminate\Database\Eloquent\Model;

class SupplierStockItemList extends Model
{

    protected $table = 'supplier_stock_item_lists';
    public $timestamps = false;

    public function front_group()
    {
        return $this->belongsTo(FrontGroup::class,"front_group_id","id");
    }

    //2020-12-31 使用修改器將canordertime修改成字符串
    public function setItemListAttribute($value)
    {
        if(is_array($value)){
            $this->attributes['item_list'] = implode(",", array_filter($value, function ($var) {
                //array_filter不去掉0
                return ($var === '' || $var === null || $var === false) ? false : true;
            }));
        }else{
            $this->attributes['item_list'] = $value;
        }
    }

}
