<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class TblNotice extends Model
{
	
    protected $table = 'tbl_notice';

    protected $primaryKey = 'int_id';

    public $timestamps = false;

}
