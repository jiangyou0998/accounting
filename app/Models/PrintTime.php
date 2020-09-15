<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class PrintTime extends Model
{

    protected $table = 'print_time';
    public $timestamps = false;

    public $fillable = ['check_id', 'time', 'weekday'];

    public function user()
    {
        return $this->belongsTo(WorkshopCheck::class, "check_id", "id");
    }

}
