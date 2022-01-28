<?php

namespace App\Models\KB;


use Illuminate\Database\Eloquent\Model;

class KBForbiddenDate extends Model
{
    protected $connection = 'mysql_kb';
    protected $table = 'forbidden_dates';
    public $timestamps = false;

}
