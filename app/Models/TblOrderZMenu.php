<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TblOrderZMenu extends Model
{

    protected $table = 'tbl_order_z_menu';

    protected $primaryKey = 'int_id';

    public $timestamps = false;



}
