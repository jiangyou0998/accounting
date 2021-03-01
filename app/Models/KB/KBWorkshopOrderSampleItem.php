<?php

namespace App\Models\KB;


use Illuminate\Database\Eloquent\Model;

class KBWorkshopOrderSampleItem extends Model
{
    protected $connection = 'mysql_kb';
    protected $table = 'workshop_order_sample_item';
    public $timestamps = false;

}
