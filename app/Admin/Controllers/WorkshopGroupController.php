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

            //2021-03-18 禁用詳情、刪除按鈕
            $grid->disableViewButton();
            $grid->disableDeleteButton();

            $grid->showQuickEditButton();

            $grid->model()->with('cats');
            $grid->id->sortable();
            $grid->column('cats.cat_name','大類');
            $grid->group_name;
            $grid->sort;
//            $grid->status;
            $grid->last_modify;

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->where('cat_id', function ($query) {

                    $query->whereHas('cats', function ($query) {
                        $query->where('id', '=', $this->input);
                    });

                }, '大類')->select('api/cat');

                $filter->like('group_name');

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

            $form->tools(function (Form\Tools $tools) {
                // 去掉跳转列表按钮
//                $tools->disableList();
                // 去掉跳转详情页按钮
                $tools->disableView();
                // 去掉删除按钮
                $tools->disableDelete();

                // 添加一个按钮, 参数可以是字符串, 匿名函数, 或者实现了Renderable或Htmlable接口的对象实例
//                $tools->append('<a class="btn btn-sm btn-danger"><i class="fa fa-trash"></i>&nbsp;&nbsp;delete</a>');
            });

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
