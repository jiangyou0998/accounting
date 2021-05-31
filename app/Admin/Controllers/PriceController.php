<?php

namespace App\Admin\Controllers;


use App\Models\Price as PriceModel;
use App\Models\ShopGroup;
use App\Models\WorkshopCat;
use App\Models\WorkshopCheck;
use App\Models\WorkshopGroup;
use App\Models\WorkshopProduct;
use App\Models\WorkshopUnit;
use Dcat\Admin\Admin;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Illuminate\Support\Facades\DB;


class PriceController extends AdminController
{
    protected $title = '價格查詢';
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

            //禁用操作
            $grid->disableActions();
            //禁用新增
            $grid->disableCreateButton();
            //禁用 导出所有 选项
            $grid->export()->disableExportCurrentPage();
            //禁用 导出选中行 选项
            $grid->export()->disableExportSelectedRow();

            $grid->model()
                ->select(DB::raw('prices.*,workshop_products.product_no'))
                ->whereHas('products',function ($query){
                    $query->where('status','!=',4);
                })
                ->leftJoin('workshop_products','workshop_products.id', '=', 'prices.product_id')
                ->with('products')
                ->with(['shopGroup'])
                ->orderBy('shop_group_id')
                ->orderBy('workshop_products.product_no');

            $grid->column('id')->sortable();
            $grid->column('products.product_no', '產品編號');
            $grid->column('products.product_name', '產品名稱');
            $grid->column('products.cats.cat_name', '大類');
            $grid->column('products.groups.group_name','細類');
            $grid->column('shopGroup.name', '分組');
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

            $titles = [
                'id' => 'id',
                'product_no' => '貨品編號',
                'product_id' => '貨品名',
                'shop_group_id' => '分組名',
                'price' => '價格',
                'new_price' => '價格new',
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
                $filter->like('products.product_no', '產品編號');
                $filter->like('products.product_name', '產品名稱');

            });

            //2021-05-05 價格分組數組
            $shopGroupArr = ShopGroup::orderBy('sort')->pluck('name','id');
            //2021-05-05 大類數組
            $catArr = WorkshopCat::orderBy('sort')->pluck('cat_name','id');
            //2021-05-05 細類數組
            $groupArr = WorkshopGroup::orderBy('sort')->pluck('group_name','id');
            //選擇器
            $grid->selector(function (Grid\Tools\Selector $selector) use($shopGroupArr, $catArr, $groupArr){
                //分組
                $selector->select('shop_group_id', '分組', $shopGroupArr);
                //大類
                $selector->select('cat_id', '大類', $catArr, function ($query, $value){
                    $query->whereHas('products', function ($query) use($value){
                        $query->whereHas('groups', function ($query) use($value){
                            $query->whereHas('cats', function ($query) use($value){
                                $query->whereIn('id', $value);
                            });
                        });
                    });
                });
                //細類
                $selector->select('group_id', '細類', $groupArr, function ($query, $value){
                    $query->whereHas('products', function ($query) use($value){
                        $query->whereHas('groups', function ($query) use($value){
                            $query->whereIn('id', $value);
                        });
                    });
                });

            });

        });
    }

}
