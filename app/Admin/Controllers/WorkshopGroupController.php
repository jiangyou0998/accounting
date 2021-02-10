<?php

namespace App\Admin\Controllers;

use App\Models\WorkshopGroup;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class WorkshopGroupController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new WorkshopGroup(), function (Grid $grid) {
            $grid->model()->with('cats');
            $grid->id->sortable();
            $grid->column('cats.cat_name','大類');
            $grid->group_name;
            $grid->sort;
//            $grid->status;
            $grid->last_modify;

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
        return Show::make($id, new WorkshopGroup(), function (Show $show) {
            $show->id;
            $show->group_name;
            $show->sort;
            $show->status;
            $show->cat_id;
            $show->short_name;
            $show->last_modify;
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new WorkshopGroup(), function (Form $form) {
            $form->display('id');
            $form->text('group_name')->required();
            $form->text('sort')->required();
            $form->hidden('status');
            $form->select('cat_id','大類')->options('/api/cat')->required();
            $form->hidden('short_name');

            if($form->isEditing()){
                $form->display('last_modify');
            }

            $form->saving(function (Form $form) {

                $user = Admin::user();
                $last_modify = "(".$user->id.")".$user->username." ".now();
                if($form->isCreating()){
                    $form->input('status',1);
                }
                // 修改
                $form->input('short_name' ,$form->input('group_name'));
                $form->input('last_modify', $last_modify);

            });
        });
    }
}
