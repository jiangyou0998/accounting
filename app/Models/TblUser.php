<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class TblUser extends Model
{

    protected $table = 'tbl_user';

    protected $primaryKey = 'int_id';

    public $timestamps = false;

}
