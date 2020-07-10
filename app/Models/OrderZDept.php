<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderZDept extends Model
{
    //
    protected $table = 'tbl_order_z_dept';

    public $timestamps = false;

    protected $primaryKey = 'int_id';

    protected $guarded = [
        'int_id'
    ];
}
