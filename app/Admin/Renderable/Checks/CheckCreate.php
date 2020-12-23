<?php

namespace App\Admin\Renderable\Checks;

use App\Models\WorkshopCat;
use App\Models\WorkshopGroup;
use App\Models\WorkshopProduct;
use Dcat\Admin\Admin;
use Illuminate\Contracts\Support\Renderable;

class CheckCreate implements Renderable
{
    // 定义页面所需的静态资源，这里会按需加载
    public static $js = [
        '//cdnjs.cloudflare.com/ajax/libs/json3/3.3.2/json3.min.js',
        '/js/parser.js',
        '/js/MultipleSelect/multiple-select.js',
        '/js/My97DatePicker/WdatePicker.js',

    ];
    public static $css = [
        '/js/MultipleSelect/multiple-select.css',
        '/css/checkbox-style.css',
    ];

    private $id;

    public function script()
    {
        return <<<JS
        console.log('所有JS脚本都加载完了');

JS;
    }

    public function __construct()
    {

    }

    public function render()
    {
        //todo
        // 在这里可以引入你的js或css文件
        Admin::js(static::$js);
        Admin::css(static::$css);

        // 需要在页面执行的JS代码
        // 通过 Admin::script 设置的JS代码会自动在所有JS脚本都加载完毕后执行
        Admin::script($this->script());

        $cats = WorkshopCat::orderBy('sort')->get(['id', 'cat_name']);
        $groups = WorkshopGroup::orderBy('sort')->get(['id', 'group_name', 'cat_id']);
        $products = WorkshopProduct::where('status', '<>', 4)
            ->orderBy('sort')
            ->get(['id', 'product_name', 'group_id', 'product_no']);

        return view('admin.checks.create',compact('cats', 'groups', 'products'))->render();
    }

}
