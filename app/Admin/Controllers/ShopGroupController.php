<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\ShopGroup;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class ShopGroupController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new ShopGroup(), function (Grid $grid) {
            $grid->id->sortable();
            $grid->name;
            $grid->sort;
            $grid->created_at;
            $grid->updated_at->sortable();
        
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
        return Show::make($id, new ShopGroup(), function (Show $show) {
            $show->id;
            $show->name;
            $show->sort;
            $show->created_at;
            $show->updated_at;
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new ShopGroup(), function (Form $form) {
            $form->display('id');
            $form->text('name');
            $form->text('sort');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
