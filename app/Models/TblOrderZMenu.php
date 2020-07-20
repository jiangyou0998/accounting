<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    public function tblUser(): BelongsToMany
    {
        $pivotTable = 'tbl_order_z_menu_v_shop'; // 中间表

        $relatedModel = tblUser::class; // 关联模型类名

        return $this->belongsToMany($relatedModel, $pivotTable, 'int_user_id', 'int_menu_id');
    }

}
