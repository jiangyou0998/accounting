<?php

namespace App\Models\KB;


use Illuminate\Database\Eloquent\Model;

class KBWorkshopUnit extends Model
{
    protected $connection = 'mysql_kb';
    protected $table = 'workshop_units';
    public $timestamps = false;

    public function products()
    {
        return $this->hasMany(KBWorkshopProduct::class,"unit_id","id");
    }

}
