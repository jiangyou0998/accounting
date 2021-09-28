<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class SelectorItem extends Model
{

    protected $table = 'selector_items';
    public $timestamps = false;

    public static function getSelectorItems(string $type_name)
    {
        return self::where('type_name', $type_name)->orderBy('sort')->get();
    }

}
