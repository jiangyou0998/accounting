<?php

namespace App\Admin\Controllers\Library;


use App\Models\Library\LibraryGroup;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Form;
use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Tree;
use Dcat\Admin\Widgets\Box;
use Dcat\Admin\Widgets\Form as WidgetForm;


class LibraryGroupController extends AdminController
{
    public function index(Content $content)
    {
        return $content->header('圖書館分組')
            ->body(function (Row $row) {
                $row->column(7, $this->treeView()->render());

                $row->column(5, function (Column $column) {
                    $form = new WidgetForm();
//                    $form->action(admin_url('auth/menu'));

                    $libraryModel = LibraryGroup::class;

                    $form->select('parent_id', '父級')->options($libraryModel::selectOptions());
                    $form->text('title', '標題')->required();

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
        $libraryModel = LibraryGroup::class;

        return new Tree(new $libraryModel(), function (Tree $tree) {
            $tree->disableCreateButton();
            $tree->disableQuickCreateButton();
            $tree->disableEditButton();
            $tree->disableQuickEditButton();
            $tree->disableDeleteButton();
            $tree->disableSaveButton();

            $tree->branch(function ($branch) {
//                dump($branch);
                $payload = "<i class='fa {$branch['icon']}'></i>&nbsp;<strong>{$branch['title']}</strong>";

//                if (! isset($branch['children'])) {
//                    $id = $branch['id'];
//
//                    $payload .= "&nbsp;&nbsp;&nbsp;<a href=\"www.baidu.com\" class=\"dd-nodrag\"  target='_blank'>查看</a>";
//                }
                if ($branch['parent_id'] !== 0) {
                    $id = $branch['id'];
                    $url = admin_url('library')."?group_id={$id}";

                    $payload .= "&nbsp;&nbsp;&nbsp;<a href=\"{$url}\" class=\"dd-nodrag\"  target='_blank'>查看</a>";
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
        $libraryModel = LibraryGroup::class;

        return Form::make(new LibraryGroup(), function (Form $form) use ($libraryModel) {
            $form->tools(function (Form\Tools $tools) {
                $tools->disableView();
            });

            $form->display('id', 'ID');

            $form->select('parent_id', '父級')->options(function () use ($libraryModel) {
                return $libraryModel::selectOptions();
            })->saving(function ($v) {
                return (int) $v;
            });
            $form->text('title', '標題')->required();

            $form->display('created_at', '建立時間');
            $form->display('updated_at', '更新時間');
        })->saved(function (Form $form, $result) {
            if ($result) {
                return $form->location('library/group', __('front.save_succeeded'));
            }

            return $form->location('library/group', [
                'message' => __('front.nothing_updated'),
                'status'  => false,
            ]);
        });
    }

}
