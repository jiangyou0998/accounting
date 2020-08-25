<?php

namespace App\Admin\Renderable;

use App\Models\Price as PriceModel;
use Dcat\Admin\Support\LazyRenderable;
use Dcat\Admin\Widgets\Table;

class Price extends LazyRenderable
{
    public function render()
    {
        // 获取ID
        $id = $this->id;

        // 获取其他自定义参数
//        $type = $this->post_type;

        $data = PriceModel::where('menu_id', $id)
//            ->where('type', $type)
            ->join('shop_groups','shop_groups.id','=','prices.shop_group_id')
            ->orderBy('shop_groups.sort')
            ->get(['shop_groups.name','price'])

            ->toArray();

        $titles = [];

        if(count($data)>0){
            $titles = [
                '分組',
                '價格',
            ];
        }


//        dump($data);

        return Table::make($titles, $data);
    }
}
