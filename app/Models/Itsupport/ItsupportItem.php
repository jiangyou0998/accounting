<?php

namespace App\Models\Itsupport;


use Illuminate\Database\Eloquent\Model;

class ItsupportItem extends Model
{

    protected $table = 'itsupport_items';
    public $timestamps = false;

    public function details()
    {
        return $this->hasMany(ItsupportDetail::class , 'item_id' , 'id');
    }

}
