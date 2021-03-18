<?php

namespace App\Admin\Controllers;

use App\Models\SpecialDate;
use App\Models\WorkshopCat;
use App\User;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class SpecialDateController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new SpecialDate(), function (Grid $grid) {

            $grid->disableViewButton();

            $grid->model()->latest('id');

            $grid->column('id')->sortable();

            $catArr = WorkshopCat::all()->pluck('cat_name','id')->toArray();
            $grid->column('cat_ids')->explode()->map(function ($item, $key) use ($catArr){
                return $catArr[$item] ?? $item;
            })->label('danger');

            $userArr = User::all()->pluck('report_name','id')->toArray();
            $grid->column('user_ids')->explode()->map(function ($item, $key) use ($userArr){
                return $userArr[$item] ?? $item;
            })->label();

            $grid->column('special_date');

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new SpecialDate(), function (Form $form) {
            $form->checkbox('cat_ids')->options(WorkshopCat::all()->pluck('cat_name','id'))->required();
            $form->checkbox('user_ids')->options(User::getAllShopsByShopGroup()->pluck('txt_name', 'id'))->required();
            $form->date('special_date')->required();
        });
    }
}
