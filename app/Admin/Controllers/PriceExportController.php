<?php

namespace App\Admin\Controllers;


use App\Models\Price as PriceModel;
use App\Models\ShopGroup;
use App\Models\WorkshopCheck;
use App\Models\WorkshopGroup;
use App\Models\WorkshopProduct;
use App\Models\WorkshopUnit;
use Dcat\Admin\Admin;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;


class PriceExportController extends AdminController
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
        return Grid::make(new PriceModel(), function (Grid $grid) {

            $grid->model()
                ->whereHas('products',function ($query){
                    $query->where('status','!=',4);
                })
                ->with('products')
//                ->with(['products' => function ($query) {
//                    return $query->orderBy('product_no','ASC');
//                }])
                ->with(['shopGroup'])
//                ->join('workshop_products', 'workshop_products.id', '=', 'prices.product_id')
//                ->orderBy('shop_group_id')
//                ->orderBy('workshop_products.product_no')
                ;

            $grid->id()->sortable();
            $grid->column('products.product_no');
            $grid->column('products.product_name');
            $grid->column('shopGroup.name');
            $grid->price;

            //細類數組
            $products = new WorkshopProduct();

            $productArr = array();
            $products = $products::with('prices')->get();
            foreach ($products as $product) {
                $productArr[$product['id']] = $product->toArray();
            }

            $shop_groups = new ShopGroup();
            $shopGroupArr = array();
            $shop_groups = $shop_groups::with('price')->get();
            foreach ($shop_groups as $shop_group) {
                $shopGroupArr[$shop_group['id']] = $shop_group->toArray();
            }

//            dump($shopGroupArr);

            $titles = [
                'id' => 'id',
                'product_no' => '貨品編號',
                'product_id' => '貨品名',
                'shop_group_id' => '分組名',
                'price' => '價格',
            ];

            $grid->export($titles)->csv()->rows(function (array $rows) use($productArr, $shopGroupArr){
                foreach ($rows as $index => &$row) {
                    $row['product_no'] = $productArr[$row['product_id']]['product_no'];
                    $row['product_id'] = $productArr[$row['product_id']]['product_name'];
                    $row['shop_group_id'] = $shopGroupArr[$row['shop_group_id']]['name'];
                }
                return $rows;
            });

            //------------------------------------------------------------------
            //過濾器
            $grid->filter(function (Grid\Filter $filter) {

                $filter->equal('id');
                $filter->like('product_no');
                $filter->like('product_name');
                $filter->equal('cuttime');


            });


        });
    }

}
