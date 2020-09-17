<?php

namespace App\Admin\Renderable;

use App\Models\Price as PriceModel;
use App\Models\WorkshopCartItemLog;
use Dcat\Admin\Support\LazyRenderable;
use Dcat\Admin\Widgets\Table;

class CartitemLog extends LazyRenderable
{
    public function render()
    {
        // 获取ID
        $id = $this->id;

        // 获取其他自定义参数
//        $type = $this->post_type;

        $logs = WorkshopCartItemLog::with('operate_users')
            ->with('shops')
            ->with('products')
            ->with('cart_items')
            ->where('cart_item_id', $id)
            ->get()
            ;

        $titles = [];

//        dump($logs->);

        $data = [];
        foreach ($logs as $key => $log){
//            $data['shop']=$log->shops()->
            $data[$key]['shop'] = $log->shops->txt_name;
            $data[$key]['operate_user'] = $log->operate_users->txt_name;
            $data[$key]['ip'] = $log->ip;
            $data[$key]['input'] = $log->input;
            $data[$key]['deli_date'] = $log->cart_items->deli_date;
            $data[$key]['created_at'] = $log->created_at;
//            $data[$key]['created_at'] = $log->cart_items->reason;
//            dump($log->shops->txt_name);
        }


        if(count($data)>0){
            $titles = [
                '商店',
                '操作人',
                'IP',
                '描述',
                '送貨時間',
                '操作時間',
//                '原因',
            ];
        }


//        dump($data);

        return Table::make($titles, $data);
    }
}
