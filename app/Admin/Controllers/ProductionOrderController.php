<?php

namespace App\Admin\Controllers;

use App\Models\MyPage;
use App\Models\ProductionOrder;
use App\Models\WorkshopCat;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class ProductionOrderController extends AdminController
{

    public function index(Content $content)
    {
        return $content
            ->title('查看生產表')
            ->body(new ProductionOrder());
    }


    /**
     * Make a grid builder.
     *
     * @return Grid
     */

    protected function grid()
    {
        return Grid::make(new WorkshopCat(), function (Grid $grid) {
            $grid->header(function ($collection) use ($grid) {
                $grid->time('column_name', 'placeholder...');
            });


            $grid->model()->orderBy('sort');
            $grid->column('cat_name','生產單名');

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
        return Show::make($id, new ProductionOrder(), function (Show $show) {
            $show->field('id');
        });
    }

    /**
     * Make a forms builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new ProductionOrder(), function (Form $form) {
            $form->display('id');
        });
    }
}
