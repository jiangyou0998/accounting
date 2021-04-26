<?php

namespace App\Models\KB;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class KBWorkshopProduct extends Model
{

    protected $connection = 'mysql_kb';
    protected $table = 'workshop_products';

//    protected $appends = ['full_name'];

    public function groups()
    {
        return $this->belongsTo(KBWorkshopGroup::class,"group_id","id");
    }

    public function cats()
    {
        return $this->hasOneThrough(KBWorkshopCat::class,KBWorkshopGroup::class,"id" ,"id","group_id","cat_id");
    }

    public function units()
    {
        return $this->belongsTo(KBWorkshopUnit::class,"unit_id","id");
    }

    public function prices()
    {
        return $this->hasMany(KBPrice::class,"product_id","id");
    }

    public function allProduct()
    {
        $cats = new KBWorkshopCat();
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

//    public function getFullNameAttribute()
//    {
//        return "{$this->product_name} {$this->product_no}";
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
