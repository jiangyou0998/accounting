<?php

namespace App\Models\Itsupport;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Itsupport extends Model
{

    protected $guarded = [];

    public function users()
    {
        return $this->hasOne(User::class,'id','user_id');
    }

    public function items()
    {
        return $this->hasOne(ItsupportItem::class,'id','itsupport_item_id');
    }

    public function details()
    {
        return $this->hasOne(ItsupportDetail::class,'id','itsupport_detail_id');
    }



}
