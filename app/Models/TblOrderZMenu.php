<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class TblOrderZMenu extends Model
{

    protected $table = 'tbl_order_z_menu';

    protected $primaryKey = 'int_id';

    public $timestamps = false;

    public function tblOrderZGroup()
    {
        return $this->belongsTo(TblOrderZGroup::class,"int_group","int_id");
    }

    public function tblOrderZCat()
    {
        return $this->hasOneThrough(TblOrderZCat::class,TblOrderZGroup::class,"int_id" ,"int_id","int_group","int_cat");
    }

    public function tblOrderZUnit()
    {
        return $this->belongsTo(TblOrderZUnit::class,"int_unit","int_id");
    }

}
