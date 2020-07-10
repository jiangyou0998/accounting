<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class TblOrderZUnit extends Model
{

    protected $table = 'tbl_order_z_unit';

    protected $primaryKey = 'int_id';

    public $timestamps = false;

    public function tblOrderZMenu()
    {
        return $this->hasMany(TblOrderZMenu::class,"int_unit","int_id");
    }

}
