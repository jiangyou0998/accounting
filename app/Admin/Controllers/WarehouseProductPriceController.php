<?php

namespace App\Admin\Controllers;

use App\Models\WarehouseProduct;
use App\Models\WarehouseProductPrice;
use Carbon\Carbon;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class WarehouseProductPriceController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new WarehouseProductPrice(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('price');
            $grid->column('base_price');
            $grid->column('product_id');
            $grid->column('sort');
            $grid->column('start_date');
            $grid->column('end_date');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->panel();
                $filter->equal('id');

                $products = WarehouseProduct::query()->notDisabled()->pluck('product_name_short','id');
                $filter->equal('product_id')->select($products);

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
        return Show::make($id, new WarehouseProductPrice(), function (Show $show) {
            $show->field('id');
            $show->field('price');
            $show->field('base_price');
            $show->field('product_id');
            $show->field('sort');
            $show->field('start_date');
            $show->field('end_date');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new WarehouseProductPrice(), function (Form $form) {
            $form->display('id');
            $form->text('price')
                ->rules('required|numeric|min:0.00')
                ->required();
            $form->text('base_price')
                ->rules('required|numeric|min:0.00')
                ->required();

            $products = WarehouseProduct::query()->notDisabled()->pluck('product_name_short','id');
            $form->select('product_id')->options($products)->required();
            $form->hidden('sort');
            $form->date('start_date')->required();
            $form->date('end_date');

            $form->display('created_at');
            $form->display('updated_at');

            $form->submitted(function (Form $form) {

                $form->input('sort', 2);

                $product_id = $form->input('product_id');
                $start_date = $form->input('start_date');
                $end_date = $form->input('end_date');

                if($form->end_date == ''){
                    $end_date = '9999-12-31';
                }

                $price_count = WarehouseProductPrice::query()
                    ->where('product_id', $product_id)
                    ->count();

                if($price_count === 0 && $end_date !== '9999-12-31'){
                    return $form->error('第一次設定價格必須將結束時間設置為9999-12-31');
                }

                $last_data = WarehouseProductPrice::query()
                    ->where('product_id', $product_id)
                    ->whereDate('end_date', '9999-12-31')
                    ->first();

                if(! $last_data && $price_count > 0){
                    return $form->error('服务器出错了~');
                }

//                $pre_data = WarehouseProductPrice::query()
//                    ->where('product_id', $product_id)
//                    ->whereDate('start_date', '<', $start_date)
//                    ->whereDate('end_date', '>', $start_date)
//                    ->first();
//
//                if($pre_data){
//                    dump($pre_data->toArray());
//                    $pre_data->end_date = Carbon::parse($start_date)->subDay();
//                    $pre_data->save();
//                }
//
//                $next_data = WarehouseProductPrice::query()
//                    ->where('product_id', $product_id)
//                    ->whereDate('start_date', '<', $end_date)
//                    ->whereDate('end_date', '>', $end_date)
//                    ->first();
//
//                if ($next_data){
//                    $next_start_date = Carbon::parse($end_date)->addDay();
//                    $next_data->start_date =
//                    $next_data->save();
//                    $form->input('end_date', '9999-12-31');
//                }else{
//                    $form->input('end_date', '9999-12-31');
//                }

            });

//            $form->saved(function (Form $form, $result) {
//                // 判断是否是新增操作
//                if ($form->isCreating()) {
//                    // 自增ID
//                    $newId = $result;
//                    // 也可以这样获取自增ID
//                    $newId = $form->getKey();
//
//                    if (! $newId) {
//                        return $form->error('数据保存失败');
//                    }
//
//                    return;
//                }
//
//                // 修改操作
//            });
        });
    }
}
