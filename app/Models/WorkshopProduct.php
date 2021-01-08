<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class WorkshopProduct extends Model
{

    protected $table = 'workshop_products';

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

    public function allProduct()
    {
        $cats = new WorkshopCat();
        $cats = $cats->with('groups')->with('products')->get();
        foreach ($cats as $cat){
//            dump($cat);
            $cat->parent_id = 0;
        }
        return $cats;
//        return [
//            'id'     => 'id',
//            'text'   => 'name',
//            'parent' => 'parent_id',
//        ];
    }



}
