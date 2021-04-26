<?php

namespace App\Models\KB;


use Illuminate\Database\Eloquent\Model;

class KBSpecialDate extends Model
{
    protected $connection = 'mysql_kb';
    protected $table = 'special_dates';
    public $timestamps = false;

}
