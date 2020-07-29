<?php

namespace App\Models;

use Illuminate\Contracts\Support\Renderable;
use Dcat\Admin\Admin;

class MyPage implements Renderable
{
    // 定义页面所需的静态资源，这里会按需加载
    public static $js = [
        'xxx/js/page.min.js',
    ];
    public static $css = [
        'xxx/css/page.min.css',
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
//        Admin::js(static::$js);
//        Admin::css(static::$css);

        // 需要在页面执行的JS代码
        // 通过 Admin::script 设置的JS代码会自动在所有JS脚本都加载完毕后执行
        Admin::script($this->script());

        return view('admin.pages.my-page')->render();
    }
}
