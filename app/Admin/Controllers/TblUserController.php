<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\TblUser;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class TblUserController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new TblUser(), function (Grid $grid) {
            $grid->id->sortable();
            $grid->txt_login;
            $grid->txt_password;
            $grid->txt_name;
            $grid->chr_report_name;
            $grid->int_dept;
            $grid->int_district;
            $grid->chr_mobile;
            $grid->chr_officephone;
            $grid->chr_email;
            $grid->chr_type;
            $grid->chr_title;
            $grid->chr_fax;
            $grid->chr_outlet;
            $grid->chr_sub;
            $grid->chr_ename;
            $grid->int_boss;
            $grid->int_dis;
            $grid->chr_sap;
            $grid->int_no;
            $grid->chr_visible;
            $grid->int_force;
            $grid->chr_pocode;
            $grid->int_sort;
        
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
        return Show::make($id, new TblUser(), function (Show $show) {
            $show->id;
            $show->txt_login;
            $show->txt_password;
            $show->txt_name;
            $show->chr_report_name;
            $show->int_dept;
            $show->int_district;
            $show->chr_mobile;
            $show->chr_officephone;
            $show->chr_email;
            $show->chr_type;
            $show->chr_title;
            $show->chr_fax;
            $show->chr_outlet;
            $show->chr_sub;
            $show->chr_ename;
            $show->int_boss;
            $show->int_dis;
            $show->chr_sap;
            $show->int_no;
            $show->chr_visible;
            $show->int_force;
            $show->chr_pocode;
            $show->int_sort;
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new TblUser(), function (Form $form) {
            $form->display('id');
            $form->text('txt_login');
            $form->text('txt_password');
            $form->text('txt_name');
            $form->text('chr_report_name');
            $form->text('int_dept');
            $form->text('int_district');
            $form->text('chr_mobile');
            $form->text('chr_officephone');
            $form->text('chr_email');
            $form->text('chr_type');
            $form->text('chr_title');
            $form->text('chr_fax');
            $form->text('chr_outlet');
            $form->text('chr_sub');
            $form->text('chr_ename');
            $form->text('int_boss');
            $form->text('int_dis');
            $form->text('chr_sap');
            $form->text('int_no');
            $form->text('chr_visible');
            $form->text('int_force');
            $form->text('chr_pocode');
            $form->text('int_sort');
        });
    }
}
