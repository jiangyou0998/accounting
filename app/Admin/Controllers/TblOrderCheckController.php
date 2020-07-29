<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\TblOrderCheck;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
use Illuminate\Support\Collection;


class TblOrderCheckController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {


        $grid = new Grid(new TblOrderCheck());
            $grid->model()->collection(function (Collection $collection) {


                // 2. 给表格加一个序号列
                $collection->transform(function ($item, $index) {
                    $item['number'] = $index + 1 ;

                    return $item;
                });

                // 最后一定要返回集合对象
                return $collection;
            });

            $grid->column('number',"#");
            $grid->chr_report_name;
            $grid->int_num_of_day;
            $grid->int_sort;

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('int_id');

            });

            return $grid;

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
        return Show::make($id, new TblOrderCheck(), function (Show $show) {
            $show->int_id;
            $show->chr_report_name;
            $show->int_num_of_day;
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
        return Form::make(new TblOrderCheck(), function (Form $form) {
            $form->display('int_id');
            $form->text('chr_report_name');
            $form->text('int_num_of_day');
            $form->text('int_sort');
        });
    }
}
