<?php

namespace App\Admin\Controllers;



use App\Models\Supplier\Supplier;
use App\Models\Supplier\SupplierProduct;
use App\Models\Supplier\SupplierStockItemList;
use App\Models\SupplierGroup;
use Carbon\Carbon;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Widgets\Card;

class SupplierStockItemListController extends AdminController
{
    public function index(Content $content)
    {
        return $content
            ->header('xxxxxxxxxx')
            ->body($this->grid());
    }

    protected function grid()
    {
        return Grid::make(new SupplierStockItemList(), function (Grid $grid) {

            $month = getMonth();
            $grid->header(function ($collection) use($month){



                // 标题和内容
                $cardInfo = <<<HTML
        <h1>月份:<span style="color: red">$month</span></h1>
HTML;
                $card = Card::make('', $cardInfo);


                return $card;
            });

            //禁用操作按鈕
//            $grid->disableActions();

            $grid->model()->select('id','user_id','month')
//                ->distinct()
            ;

            $grid->user_id();
            $grid->month();


            $grid->filter(function (Grid\Filter $filter) {
                // 更改为 panel 布局
                $filter->panel();
                // 展开过滤器
                $filter->expand();
                $filter->where('month', function ($query) {
                    $query->where('month', Carbon::parse($this->input)->isoFormat('YMM'));
                }, '月份')->month();

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
        return Form::make(new SupplierStockItemList(), function (Form $form) {
            $form->text('user_id');
            $form->date('month')->format('YYYY-MM');

//            $suppliers = SupplierProduct::all()->mapToGroups(function ($item, $key) {
//                return [$item['supplier_id'] => [$item['group_id'] => $item]];
//            });
//            dump($suppliers->toArray());

            $products = SupplierProduct::getProducts();
            $supplierArr = Supplier::all()->pluck('name', 'id');
            $groupArr = SupplierGroup::all()->pluck('name', 'id');

//            dd($products->toArray());

            foreach ($products as $supplier_id => $suppliers){
                foreach ($suppliers as $group_id => $groups){
                    $form->listbox('item_list', $supplierArr[$supplier_id].'-'.$groupArr[$group_id])
                        ->options(SupplierProduct::where('supplier_id', $supplier_id)
                            ->where('group_id', $group_id)
                            ->where('status', 0)
                            ->pluck('product_name_short', 'id'));
                }
            }


//
//
//            $form->listbox('item_list', 'List2')
//                ->options(SupplierProduct::where('supplier_id', 1)
//                    ->where('group_id',1)
//                    ->pluck('product_name', 'id'));
//
//            $form->listbox('item_list', 'List3')
//                ->options(SupplierProduct::where('supplier_id', 1)
//                    ->where('group_id',3)
//                    ->pluck('product_name', 'id'));

            $form->submitted(function (Form $form) {
                // 获取用户提交参数
                $month = $form->input('month');

                $form->month = Carbon::parse($month)->isoFormat('YMM');

            });

        });
    }
}
