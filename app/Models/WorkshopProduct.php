<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class WorkshopProduct extends Model
{

    protected $table = 'workshop_products';
    protected $guarded = [];

    public function groups()
    {
        return $this->belongsTo(WorkshopGroup::class,"group_id","id");
    }

    public function cats()
    {
        return $this->hasOneThrough(WorkshopCat::class,WorkshopGroup::class,"id" ,"id","group_id","cat_id");
    }

    public function units()
    {
        return $this->belongsTo(WorkshopUnit::class,"unit_id","id");
    }

    public function prices()
    {
        return $this->hasMany(Price::class,"product_id","id");
    }

    public function cartitems()
    {
        return $this->hasMany(WorkshopCartItem::class,"product_id","id");
    }

    public function allProduct()
    {
        $cats = new WorkshopCat();
        $cats = $cats->with('groups')->with('products')->get();
        foreach ($cats as $cat){
//            dump($cat);
            $cat->parent_id = 0;
        }
        return $cats;
    }

    public function getCodeProductAttribute()
    {
        return "{$this->product_no}-{$this->product_name}";
    }

    //2020-12-31 使用修改器將canordertime修改成字符串
//    public function setCanordertimeAttribute($value)
//    {
//        $this->attributes['canordertime'] = implode(",", array_filter($value, function ($var) {
//            //array_filter不去掉0
//            return ($var === '' || $var === null || $var === false) ? false : true;
//        }));
//    }

    public static function getProductCatIds()
    {
        $query = self::query();
        $query = $query->with('cats')->get();

        $catids = $query->mapWithKeys(function ($item, $key) {
            return [$item['id'] => $item['cats']->id];
        });
        return $catids->toArray();
    }



}
