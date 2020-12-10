<?php

namespace App\Models\Repairs;


use Illuminate\Database\Eloquent\Model;

class RepairItem extends Model
{

    protected $table = 'repair_items';
    public $timestamps = false;

    public function details()
    {
        return $this->hasMany(RepairDetail::class , 'item_id' , 'id');
    }

}
