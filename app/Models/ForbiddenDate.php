<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ForbiddenDate extends Model
{

    protected $table = 'forbidden_dates';
    public $timestamps = false;

    public function setCatIdsAttribute($value)
    {
        if(is_array($value)){
            $this->attributes['cat_ids'] = implode(",", array_filter($value, function ($var) {
                //array_filter不去掉0
                return ($var === '' || $var === null || $var === false) ? false : true;
            }));
        }else{
            $this->attributes['cat_ids'] = $value;
        }
    }

    public function setUserIdsAttribute($value)
    {
        if(is_array($value)){
            $this->attributes['user_ids'] = implode(",", array_filter($value, function ($var) {
                //array_filter不去掉0
                return ($var === '' || $var === null || $var === false) ? false : true;
            }));
        }else{
            $this->attributes['user_ids'] = $value;
        }
    }

}
