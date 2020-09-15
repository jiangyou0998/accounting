<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class WorkshopCheck extends Model
{

    protected $table = 'workshop_checks';
    public $timestamps = false;

    public function printtime()
    {
        return $this->hasOne(PrintTime::class,"check_id","id");
    }

}
