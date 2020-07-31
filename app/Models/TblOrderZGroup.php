<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblOrderZGroup extends Model
{

    protected $table = 'tbl_order_z_group';

    protected $primaryKey = 'int_id';

    public $timestamps = false;

    public function tblOrderZCat()
    {
        return $this->belongsTo(TblOrderZCat::class,"int_cat","int_id");
    }

    public function tblOrderZMenu()
    {
        return $this->hasMany(TblOrderZMenu::class,"int_group","int_id");
    }

    //查詢所有轉手貨組
    public static function getResaleGroups(){

        $groups = new TblOrderZGroup();
        $groups = $groups->where('int_cat', 5)
            ->get(['int_id','chr_name']);

        return $groups;
    }

}
