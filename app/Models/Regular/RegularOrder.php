<?php

namespace App\Models\Regular;


use Illuminate\Database\Eloquent\Model;

class RegularOrder extends Model
{

    protected $table = 'regular_orders';
    public $timestamps = false;

    public function items()
    {
        return $this->hasMany(RegularOrderItem::class,"r_order_id","id");
    }

    public static function getRegularOrder()
    {
        $sampleModel = new RegularOrder();

        $samples = $sampleModel
            ->addSelect('regular_orders.product_id')
            ->addSelect('regular_orders.orderdates')
            ->addSelect('regular_order_items.r_order_id')
            ->addSelect('regular_order_items.user_id')
            ->addSelect('regular_order_items.qty');

        $samples = $samples
            ->leftJoin('regular_order_items','regular_order_items.r_order_id','=','regular_orders.id')
            ->leftJoin('workshop_products','regular_orders.product_id','=','workshop_products.id');

        $samples = $samples
            //固定柯打不能是被刪除的(1)
            ->where('regular_orders.disabled',0)
            //商品狀態不能為2(暫停),4(刪除)
            ->whereNotIn('workshop_products.status',[2,4])
            ->where('regular_order_items.disabled',0);

        $samples = $samples->get();

        return $samples;

    }

}
