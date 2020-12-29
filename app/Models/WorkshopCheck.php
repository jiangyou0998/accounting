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

    public function scopeCutDay($query)
    {
        $cutday = request()->cutday;
        if($cutday){
            return $query->where('num_of_day',$cutday);
        }
    }

    public function scopeCutTime($query)
    {
        $cuttime = request()->cuttime;
        if($cuttime){
            return $query->where('cut_time',$cuttime);
        }
    }



}
