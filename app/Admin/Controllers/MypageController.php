<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MyPage;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Layout\Content;


class MypageController extends AdminController
{
    public function index(Content $content)
    {
        // 在这里可以引入你的js或css文件
//        Admin::js(static::$js);
//        Admin::css(static::$css);

        // 需要在页面执行的JS代码
        // 通过 Admin::script 设置的JS代码会自动在所有JS脚本都加载完毕后执行
//        Admin::script($this->script());

//        return view('admin.pages.my-page')->render();
        return $content->body(new MyPage());
    }


}
