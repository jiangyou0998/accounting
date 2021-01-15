<?php

namespace App\Admin\Controllers\Library;

use App\Models\Library;
use App\Models\Library\LibraryGroup;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class LibraryController extends AdminController
{

    protected $options = [
        'FILE' => '文件上传',
        'LINK' => '鏈接',
    ];

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Library(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('name');
            $grid->column('library_type');
            $grid->column('file_path');
            $grid->column('file_name');
            $grid->column('link_path');
            $grid->column('link_name');

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');

            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new Library(), function (Show $show) {
            $show->field('id');
            $show->field('name');
            $show->field('library_type');
            $show->field('file_path');
            $show->field('file_name');
            $show->field('link_path');
            $show->field('link_name');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Library(), function (Form $form) {
            $form->display('id');
            $form->text('name');

            $libraryGroupModel = LibraryGroup::class;


            $form->tree('form2.tree', 'tree')
                ->setTitleColumn('title')
                ->nodes($libraryGroupModel->allNodes());

            $form->radio('library_type')
                ->when(['FILE', 'LINK'], function (Form $form) {

                })
                ->when('FILE', function (Form $form) {
//                    $form->text('file_name');
                    $form->file('file_path');
                })
                ->when('LINK', function (Form $form) {
//                    $form->text('link_name');
                    $form->url('link_path');
                })
                ->options($this->options)
                ->default('FILE');

        });
    }
}
