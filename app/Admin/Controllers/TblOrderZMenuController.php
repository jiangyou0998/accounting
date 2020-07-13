<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\TblOrderZMenu;
use Dcat\Admin\Admin;
use Dcat\Admin\Auth\Permission;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class TblOrderZMenuController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
//        dd(Admin::user()->can('menus'));
//        Permission::check('factory-menus');

        return Grid::make(new TblOrderZMenu(), function (Grid $grid) {

            $grid->model()
                ->with(['tblOrderZCat'])
                ->with(['tblOrderZGroup'])
                ->with(['tblOrderZUnit']);
            $grid->chr_no;
            $grid->chr_name;
            $grid->column('tblOrderZUnit.chr_name',"單位");
            $grid->int_base;
            $grid->int_min;
            $grid->int_default_price;
            $grid->column('tblOrderZCat.chr_name',"大類");
            $grid->column('tblOrderZGroup.chr_name',"細類");
            $grid->int_sort;
            $grid->chr_cuttime->label('danger');
            $grid->int_phase;
            $grid->status->using([1 => '現貨', 2 => '暫停', 3 => '新貨', 5 => '季節貨'])
                ->dot(
                    [
                        1 => 'success',
                        2 => 'danger',
                        3 => 'primary',
                        4 => Admin::color()->info(),
                    ],
                    'success' // 默认颜色
                );
            $grid->chr_canordertime;

            // 禁用分頁
//            $grid->disablePagination();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('chr_cuttime');
                $filter->equal('tblOrderZCat.chr_name');

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
        return Show::make($id, new TblOrderZMenu(), function (Show $show) {
            $show->int_id;
            $show->chr_name;
            $show->chr_no;
            $show->int_group;
            $show->int_unit;
            $show->int_base;
            $show->int_min;
            $show->int_default_price;
            $show->int_sort;
            $show->chr_cuttime;
            $show->int_phase;
            $show->status;
            $show->chr_sap;
            $show->chr_sap_2;
            $show->int_unit_2;
            $show->chr_image;
            $show->txt_detail_1;
            $show->txt_detail_2;
            $show->txt_detail_3;
            $show->last_modify;
            $show->chr_canordertime;
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new TblOrderZMenu(), function (Form $form) {
            $form->display('int_id');
            $form->text('chr_name');
            $form->text('chr_no');
            $form->text('int_group');
            $form->text('int_unit');
            $form->text('int_base');
            $form->text('int_min');
            $form->text('int_default_price');
            $form->text('int_sort');
            $form->text('chr_cuttime');
            $form->text('int_phase');
            $form->text('status');
            $form->text('chr_sap');
            $form->text('chr_sap_2');
            $form->text('int_unit_2');
            $form->text('chr_image');
            $form->text('txt_detail_1');
            $form->text('txt_detail_2');
            $form->text('txt_detail_3');
            $form->text('last_modify');
            $form->text('chr_canordertime');
        });
    }
}
