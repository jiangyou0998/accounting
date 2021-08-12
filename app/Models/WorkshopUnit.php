<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class WorkshopUnit extends Model
{

    protected $table = 'workshop_units';
    public $timestamps = false;

    protected $guarded = [];

    public function products()
    {
        return $this->hasMany(WorkshopProduct::class,"unit_id","id");
    }

}
