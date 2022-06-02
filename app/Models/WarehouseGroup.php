<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class WarehouseGroup extends Model
{

    protected $table = 'warehouse_groups';
    protected $guarded = [];

    public function warehouse_products()
    {
        return $this->hasMany(WarehouseProduct::class,"warehouse_group_id","id");
    }

}
