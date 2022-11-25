<?php

namespace App\Admin\Controllers;


use App\Models\WarehouseProduct;
use App\Models\WarehouseProductPrice;
use Carbon\Carbon;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Controllers\AdminController;
use Illuminate\Http\Request;


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

//            $grid->tools(function (Grid\Tools $tools) {
//                $tools->append(Modal::make()
//                    // 大号弹窗
//                    ->lg()
//                    // 弹窗标题
//                    ->title('上传文件')
//                    // 按钮
//                    ->button('<button class="btn btn-primary"><i class="feather icon-upload"></i> 导入数据</button>')
//                    // 弹窗内容
//                    ->body(WarehousePriceImport::make()));
//                // 下载导入模板
//                $tools->append(WarehousePriceDownloadTemplate::make()->setKey('test_question'));
//
//            });

            $grid->model()
                ->with(['product'])
                ->orderBy('product_id')
                ->orderBy('start_date');

            $grid->column('id')->sortable();
            $grid->column('price');
            $grid->column('base_price');
            $grid->column('product.product_name', '貨品名稱');
            $grid->column('sort');
            $grid->column('start_date');
            $grid->column('end_date');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->panel();
                $filter->equal('id');

                $products = WarehouseProduct::query()->notDisabled()->pluck('product_name_short','id');
                $filter->equal('product_id', '產品名稱')->select($products);

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
        return Form::make(new WarehouseProductPrice(), function (Form $form) {
            $form->model()->with('product');
            $form->display('id');
            $form->text('price')
                ->rules('required|numeric|min:0.00')
                ->required();
            $form->text('base_price')
                ->rules('required|numeric|min:0.00')
                ->required();

            $products = WarehouseProduct::query()->notDisabled()->pluck('product_name_short','id')->toArray();
            if ($form->isCreating()){
                $form->select('product_id')->options($products)->required();
            }else if ($form->isEditing()){
                $form->hidden('product_id');
                $form->display('product_id')->with(function ($value) use($products){
                    return $products[$value] ?? '';
                });
            }

            $form->hidden('sort');
            $form->date('start_date')->required();
            $form->date('end_date');

            $form->display('created_at');
            $form->display('updated_at');

            $form->submitted(function (Form $form) {

                $id = $form->getKey();

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
                    return $form->error('第一次設定價格必須將「結束時間」設置為9999-12-31');
                }

                if($start_date > $end_date){
                    return $form->error('「開始日期」不能大於「結束日期」!');
                }

                $final_price_data = WarehouseProductPrice::query()
                    ->where('product_id', $product_id)
                    ->whereDate('end_date', '9999-12-31')
                    ->first();

//                if(! $final_price_data && $price_count > 0){
//                    return $form->error('服务器出错了~');
//                }

                //開始日期 不符合要求數量統計
                $start_date_error_count = WarehouseProductPrice::query()
                    ->where('product_id', $product_id)
                    ->whereDate('start_date', '<=', $start_date)
                    ->whereDate('end_date', '>=', $start_date)
                    ->isEndDate9999($end_date)
                    ->where('id', '!=', $id)
                    ->count();

//                dump($start_date_error_count);

                if($start_date_error_count > 0){
                    return $form->error('「開始日期」已存在價格!');
                }

                //結束日期 不符合要求數量統計
                $end_date_error_count = WarehouseProductPrice::query()
                    ->where('product_id', $product_id)
                    ->whereDate('start_date', '<=', $end_date)
                    ->whereDate('end_date', '>=', $end_date)
                    ->isEndDate9999($end_date)
                    ->where('id', '!=', $id)
                    ->count();

//                dump($end_date_error_count);

                if($end_date_error_count > 0){
                    return $form->error('「結束日期」已存在價格!');
                }

                //開始日期 結束日期 之間存在價格
                $include_error_count = WarehouseProductPrice::query()
                    ->where('product_id', $product_id)
                    ->whereDate('start_date', '>=', $start_date)
                    ->whereDate('end_date', '<=', $end_date)
                    ->isEndDate9999($end_date)
                    ->where('id', '!=', $id)
                    ->count();

                if($include_error_count > 0){
                    return $form->error('選擇時間段已存在價格!');
                }

                $date_error_count = $start_date_error_count + $end_date_error_count + $include_error_count;

//                dump($id);
//                dump($final_price_data->id);
//                dump((int)$id !== $final_price_data->id);

//                dump($end_date);

                if ( 0 === $date_error_count
                    && isset($final_price_data)
                    && '9999-12-31' === $end_date
                    && (int)$id !== $final_price_data->id){

                    $final_start_date = $final_price_data->start_date;

                    if($start_date === $final_start_date){
                        return $form->error('選擇時間段已存在價格!');
                    }

                    if($start_date < $final_start_date){
                        $end_date = Carbon::parse($final_start_date)->subDay()->toDateString();
                    }

                    if($start_date > $final_start_date){
                        $final_price_data->end_date = Carbon::parse($start_date)->subDay()->toDateString();
                        $final_price_data->save();
                    }
                }

//                dump($end_date);

                $form->input('end_date', $end_date);

                return;

            });

        });
    }

    protected function import(Request $request){
        dump($request->toArray());
        return 66;
    }
}
