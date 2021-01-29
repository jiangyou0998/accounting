<?php

namespace App\Models;

use Dcat\Admin\Admin;
use Illuminate\Contracts\Support\Renderable;

class HomePage implements Renderable
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

//    public function __construct($id)
//    {
//        $this->id = $id;
//    }

    public function render()
    {
        $dept = request()->dept;
        $search = request()->search;

        $notices = Notice::getNotices($dept , $search);

        $dept_names = Notice::getDeptName();

//        dump($notices->toArray());
//        dump($dept_names->toArray());
        return view('admin.home',compact('notices','dept_names'));
    }

}
