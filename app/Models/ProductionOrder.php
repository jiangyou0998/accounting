<?php

namespace App\Models;

use Illuminate\Contracts\Support\Renderable;
use Dcat\Admin\Admin;
use Illuminate\Support\Collection;

class ProductionOrder implements Renderable
{
    // 定义页面所需的静态资源，这里会按需加载
    public static $js = [
        '/vendors/dcat-admin/dcat/plugins/moment/moment-with-locales.min.js?v1.7.0',
        '/vendors/dcat-admin/dcat/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js?v1.7.0',
        '/icheck/icheck.min.js',
    ];
    public static $css = [
        '/vendors/dcat-admin/dcat/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css?v1.7.0',
        '/icheck/skins/square/blue.css',
    ];

    public function script()
    {
        return <<<JS
        console.log('所有JS脚本都加载完了');
JS;
    }

    public function render()
    {
        // 在这里可以引入你的js或css文件
        Admin::js(static::$js);
        Admin::css(static::$css);

        // 需要在页面执行的JS代码
        // 通过 Admin::script 设置的JS代码会自动在所有JS脚本都加载完毕后执行
        Admin::script($this->script());

//        $cats = WorkshopCat::where('status',1)->get();
        $checks = WorkshopCheck::where('disabled',0)->CutDay()->CutTime()->orderBy('sort')->get();

        $cutdays = WorkshopCheck::where('disabled',0)
            ->distinct()
            ->orderBy('num_of_day')
            ->get('num_of_day');

        $cuttimes = WorkshopCheck::where('disabled',0)
            ->distinct()
            ->orderBy('cut_time')
            ->get('cut_time');

        $shop_groups = new Collection();
        $shop_groups->kb = 1;
        $shop_groups->rb = 5;
        //貳號
        $shop_groups->tc = 4;
        //機場Lagardere
        $shop_groups->la = 8;
        $customerIdArr = ShopGroup::whereNotIn('id', [1,5,4,8])->pluck('id')->toArray();
        $shop_groups->cu = implode(',', $customerIdArr);

//        dump($shop_groups);
//        dump($cutdays->toArray());

//        return view('admin.production.index',compact('cats'))->render();
        return view('admin.production.index',compact('checks','cutdays' , 'cuttimes', 'shop_groups'))->render();
    }
}
