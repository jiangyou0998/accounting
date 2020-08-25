<?php

namespace App\Admin\Controllers;

use App\Models\Menu;
use Dcat\Admin\Controllers\AdminController;

use Dcat\Admin\Form;
use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;

use Dcat\Admin\Tree;
use Dcat\Admin\Widgets\Box;
use Dcat\Admin\Widgets\Form as WidgetForm;


class MenuController extends AdminController
{
    public function index(Content $content)
    {
        return $content->header('前台導航')
            ->body(function (Row $row) {
                $row->column(7, $this->treeView()->render());

                $row->column(5, function (Column $column) {
                    $form = new WidgetForm();
//                    $form->action(admin_url('auth/menu'));

                    $menuModel = config('front.database.menu_model');
                    $permissionModel = config('front.database.permissions_model');
                    $roleModel = config('front.database.roles_model');

                    $form->select('parent_id', '父級')->options($menuModel::selectOptions());
                    $form->text('title', '標題')->required();
                    $form->text('uri', '路徑');

                    $form->hidden('_token')->default(csrf_token());

                    $form->width(9, 2);

                    $column->append(Box::make(trans('新增'), $form));
                });
            });
    }

    /**
     * @return \Dcat\Admin\Tree
     */
    protected function treeView()
    {
        $menuModel = config('front.database.menu_model');

        return new Tree(new $menuModel(), function (Tree $tree) {
            $tree->disableCreateButton();
            $tree->disableQuickCreateButton();
            $tree->disableEditButton();

            $tree->branch(function ($branch) {
                $payload = "<i class='fa {$branch['icon']}'></i>&nbsp;<strong>{$branch['title']}</strong>";

                if (! isset($branch['children'])) {
                    $uri = $branch['uri'];

                    $payload .= "&nbsp;&nbsp;&nbsp;<a href=\"$uri\" class=\"dd-nodrag\"  target='view_window'>$uri</a>";
                }

                return $payload;
            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    public function form()
    {
        $menuModel = config('front.database.menu_model');

        return Form::make(new Menu(), function (Form $form) use ($menuModel) {
            $form->tools(function (Form\Tools $tools) {
                $tools->disableView();
            });

            $form->display('id', 'ID');

            $form->select('parent_id', '父級')->options(function () use ($menuModel) {
                return $menuModel::selectOptions();
            })->saving(function ($v) {
                return (int) $v;
            });
            $form->text('title', '標題')->required();
            $form->text('uri', '路徑');


            $form->display('created_at', '建立時間');
            $form->display('updated_at', '更新時間');
        })->saved(function (Form $form, $result) {
            if ($result) {
                return $form->location('front/menu', __('front.save_succeeded'));
            }

            return $form->location('front/menu', [
                'message' => __('front.nothing_updated'),
                'status'  => false,
            ]);
        });
    }

}
