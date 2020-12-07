<?php

namespace App\Models\Repairs;


use Illuminate\Database\Eloquent\Model;

class RepairLocation extends Model
{

    protected $table = 'repair_locations';
    public $timestamps = false;

    public function items()
    {
        return $this->hasMany(RepairItem::class , 'repair_location_id' , 'id');
    }

}
