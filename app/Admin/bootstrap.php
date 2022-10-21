<?php

use Dcat\Admin\Grid;
use Dcat\Admin\Form;
use Dcat\Admin\Layout\Navbar;

/**
 * Dcat-admin - admin builder based on Laravel.
 * @author jqh <https://github.com/jqhph>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 *
 * extend custom field:
 * Dcat\Admin\Form::extend('php', PHPEditor::class);
 * Dcat\Admin\Grid\Column::extend('php', PHPEditor::class);
 * Dcat\Admin\Grid\Filter::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */

//初始化Grid
Grid::resolving(function (Grid $grid) {

    //清空搜索條件
    $grid->tools(function (Grid\Tools $tools){
        $previewUrl = '/'.request()->path();
        $class = 'btn-white';
        $clear_filter_button =  "<a href='{$previewUrl}' class='btn {$class} clear-filter'> &nbsp;&nbsp;&nbsp;<i class=' fa  fa-refresh'></i>&nbsp;清空搜索條件&nbsp;&nbsp;&nbsp; </a>";
        $tools->append($clear_filter_button);
    });

    //禁用詳情按鈕
    $grid->disableViewButton();

    //启用快速编辑
    $grid->showQuickEditButton();
});

//初始化Form
Form::resolving(function (Form $form) {

    // 去掉`查看`checkbox
    $form->disableViewCheck();

    // 去掉`继续编辑`checkbox
    $form->disableEditingCheck();

    // 去掉`继续创建`checkbox
    $form->disableCreatingCheck();

    $form->tools(function (Form\Tools $tools) {
        // 去掉`查看`按钮
        $tools->disableView();
    });

});

Admin::navbar(function (Navbar $navbar) {

    //測試環境提示
    if (app()->environment('local')){

        $test_html = <<<HTML
    <span style="color: red;font-size: xx-large">測試環境</span>
HTML;
        $navbar->right($test_html);
    }

});
