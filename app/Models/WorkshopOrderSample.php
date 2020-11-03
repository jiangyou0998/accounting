<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class WorkshopOrderSample extends Model
{

    protected $table = 'workshop_order_sample';
    public $timestamps = false;

    public static function getSampleByDept($dept)
    {
        $sampleModel = new WorkshopOrderSample();

        $samples = $sampleModel
            ->addSelect('workshop_order_sample.user_id')
            ->addSelect('workshop_order_sample.sampledate')
            ->addSelect('workshop_order_sample.dept')
            ->addSelect('workshop_order_sample_item.product_id')
            ->addSelect('workshop_order_sample_item.qty');

        $samples = $samples
            ->leftJoin('workshop_order_sample_item','workshop_order_sample_item.sample_id','=','workshop_order_sample.id');

        $samples = $samples
            ->where('workshop_order_sample.dept' , $dept)
            ->where('workshop_order_sample.disabled',0)
            ->where('workshop_order_sample_item.disabled',0);

        $samples = $samples->get();

        return $samples;

    }

}
