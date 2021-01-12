<?php

namespace App\Admin\Controllers;

use App\Admin\Renderable\Price;
use App\Models\WorkshopCheck;
use App\Models\WorkshopGroup;
use App\Models\WorkshopUnit;
use App\Models\WorkshopProduct;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use App\Models\Price as PriceModel;

class WorkshopProductController extends AdminController
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


        return Grid::make(new WorkshopProduct(), function (Grid $grid) {


            if(Admin::user()->can('factory-menus') === false){
                // 禁用创建按钮
                $grid->disableCreateButton();
                // 禁用行操作按钮
                $grid->disableActions();
            }

            $grid->showQuickEditButton();

            // 表格快捷搜索
            $grid->quickSearch('product_no','product_name')
                ->placeholder('輸入「編號」或「名稱」快速搜索');


            //生產表數組
            $checks = new WorkshopCheck();

            $checkArr = array();

            foreach ($checks::all() as $check) {
                $menuIdArr = explode(',',$check->item_list);
                foreach ($menuIdArr as $menu){
                    $tempArr =  explode(':', $menu);
                    $checkArr[$tempArr[1]] = $check->report_name;
                }

            }

            //單位數組
            $units = new WorkshopUnit();

            $unitArr = array();
            foreach ($units::all() as $unit) {
                $unitArr[$unit['id']] =  $unit['unit_name'];
            }

            //細類數組
            $groups = new WorkshopGroup();

            $groupArr = array();
            $groups = $groups::with('cats')->get();
            foreach ($groups as $group) {
//                dump($group->toArray()['tbl_order_z_cat']);
                $groupArr[$group['id']] = $group->toArray()['cats']['cat_name'].'-'.$group['group_name'];
            }


//            dd($groupArr);


//            $menu = new \App\Models\WorkshopProduct
//
//            dd($menu);

            $grid->model()
                ->with(['cats'])
                ->with(['groups'])
                ->with(['units'])
                ->with(['prices'])
                ->where('status','<>', 4)
                ->orderBy('product_no');

//            dd($grid->model()->collection()->toArray());
            $grid->model()->collection(function (Collection $collection) {


//                $collection->transform(function ($item) {
//
//                    return $item;
//                });

                //给表格加一个序号列
                $collection->transform(function ($item, $index) {
                    $item['number'] = $index + 1 ;

                    return $item;
                });

                // 最后一定要返回集合对象
                return $collection;
            });

            $grid->column('number',"#");
            $grid->product_no->sortable();
            $grid->product_name;
            $grid->column('units.unit_name',"單位");
//            $grid->price->display('View')->modal('Price', Price::make(['int_id' => $this->int_id]));
            $grid->price->display('分組價格')->expand(function () {
                // 允许在比包内返回异步加载类的实例
                return Price::make(['id' => $this->id]);
            });

            $grid->column('cats.cat_name',"大類");
            $grid->column('groups.group_name',"細類");
            $grid->sort;
//            $grid->phase->display(function ($phase) {
//
//                if($phase > 0){
//                    return $phase."日後";
//                }else{
//                    return "<span style='color:red'>後勤落單</span>";
//                }
//
//
//            });

//            $grid->int_phase;

//            $grid->status->using([1 => '現貨', 2 => '暫停', 3 => '新貨', 5 => '季節貨'])
//                ->dot(
//                    [
//                        1 => 'success',
//                        2 => 'danger',
//                        3 => 'primary',
//                        4 => Admin::color()->info(),
//                    ],
//                    'success' // 默认颜色
//                );

            //2020-12-30 狀態使用radio
            $grid->column('status')->radio([1 => '現貨', 2 => '暫停', 3 => '新貨', 5 => '季節貨']);

            $grid->column('所屬生產表')->display(function () use ($checkArr) {
                if (isset($checkArr[$this->id])){
                    return $checkArr[$this->id];
                }else{
                    return "不在生產表中";
                }

            });


            $prices = PriceModel::where('shop_group_id', 1)->get();
//            dump($prices->toArray());
//            foreach ($prices as $price){
//                $price->xxx = $price->prices()->pluck('price','shop_group_id');
//                $price->moq = $price->prices()->pluck('min','shop_group_id');
////                dump($price->toArray());
//            }

            $titles = [
                'product_no' => '編碼',
                'product_name' => '貨名',
                'group_id' => '細類',
                'min' => 'MOQ',
                'unit_id' => '包裝' ,
                'kb_price' => '蛋撻王單價',
                'rb_price' => '糧友單價',
                ];
            $grid->export($titles)->rows(function (array $rows) use ($groupArr , $unitArr){
                foreach ($rows as $index => &$row) {
                    $row['group_id'] = $groupArr[$row['group_id']];
                    $row['unit_id'] = $unitArr[$row['unit_id']];


                    $kbprice = Arr::where($row['prices'], function ($value, $key) {
                        return ($value['shop_group_id'] == 1);
                    });
                    $row['kb_price'] = $kbprice[0]['price'];

                    $rbprice = Arr::where($row['prices'], function ($value, $key) {
                        return ($value['shop_group_id'] == 5);
                    });
                    if(isset($rbprice[0])){
                        $row['rb_price'] = $rbprice[0]['price'];
                    }else{
                        $row['rb_price'] = '';
                    }

                }

                return $rows;
            });

            //------------------------------------------------------------------
            //過濾器
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('cuttime');
                $filter->like('product_name');
                $filter->like('product_no');
                $filter->equal('status')->select([1 => '現貨', 2 => '暫停', 3 => '新貨', 5 => '季節貨']);

                $filter->where('cat_id', function ($query) {

                    $query->whereHas('groups', function ($query) {
                        $query->whereHas('cats', function ($query) {
                            $query->where('id', '=', $this->input);
                        });
                    });

                }, '大類')->select('api/cat')->load('group', '/api/group');

                $filter->where('group', function ($query) {

                    $query->whereHas('groups', function ($query) {
                        $query->where('id', '=', $this->input);
                    });

                }, '細類')->select('api/group2')->default("");



            });

            //選擇器
            $grid->selector(function (Grid\Tools\Selector $selector) {


                $selector->selectOne('price', '有價格', [
                    1 => '蛋撻王',
                    5 => '糧友',
                ], function ($query, $value) {

//                    $value = current($value);

                    $query->whereHas('prices', function ($query) use($value){
                        $query->where('shop_group_id', $value);
                    });

                });


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
        $builder = new WorkshopProduct();
        $builder = $builder->with('prices');

        return Form::make($builder, function (Form $form) {

//            $form->action($this->confirm1());

            $form->tools(function (Form\Tools $tools) {
                // 去掉跳转列表按钮
//                $tools->disableList();
                // 去掉跳转详情页按钮
                $tools->disableView();
                // 去掉删除按钮
//                $tools->disableDelete();

                // 添加一个按钮, 参数可以是字符串, 匿名函数, 或者实现了Renderable或Htmlable接口的对象实例
//                $tools->append('<a class="btn btn-sm btn-danger"><i class="fa fa-trash"></i>&nbsp;&nbsp;delete</a>');
            });




            $form->display('id',"ID");
            $form->text('product_name')->required();
            $form->text('product_no')->required()->rules("required|
                max:7|unique:workshop_products,product_no,{$form->getKey()},id", [
                'max' => '編號最大長度為7',
                'unique'   => '編號已存在',
            ]);
//                ;
//            $form->text('product_no')->required()->rules(function ($form) {
//
//                return [
//                    'required',
//                    'max:7',
//                    Rule::unique('tbl_order_z_menu')->ignore($form->getKey(),'int_id'), [
//                        'max' => '編號最大長度為7',
//                        'unique'   => '編號已存在',
//                    ]
//                ];
//
//            });

            $form->select('','大類')->options('/api/cat')->load('group_id', '/api/group');

            $form->select('group_id')->options('/api/group2')->required();
//            $form->text('int_group')->required();

            $form->select('unit_id')->options('/api/unit')->required();

            $form->text('sort')
                ->type('number')
                ->required();


            $status = [
                1 => '現貨',
                2 => '暫停',
                3 => '新貨',
                5 => '季節貨'
            ];
            $form->radio('status')->options($status)->required();

            $week = [
                0 => '星期日',
                1 => '星期一',
                2 => '星期二',
                3 => '星期三',
                4 => '星期四',
                5 => '星期五',
                6 => '星期六'
            ];

            $form->display('last_modify');


            $form->hasMany('prices', '價格列表', function (Form\NestedForm $form) use($week){
                $form->select('shop_group_id', '商店分組')->options('api/shopgroup')->rules('required');
//                $form->text('shop_group_id', '商店分組')->rules('required');
                $form->currency('price','單價')->symbol('$')->rules('required|numeric|min:0.01');
                $form->text('base')
                    ->type('number')
                    ->attribute('min', 0)
                    ->required();
                $form->text('min')
                    ->type('number')
                    ->attribute('min', 0)
                    ->required();
                $form->text('cuttime')
                    ->type('number')
                    ->attribute('min', 0)
                    ->required();
                $form->radio('phase')
                    ->options([1 => '1日後', 2 => '2日後', 3 => '3日後', -1 => '後勤落單'])
                    ->required();
                $form->checkbox('canordertime')
                    ->options($week)
                ;
            });


            $form->saving(function (Form $form) {

                $user = Admin::user();
                $last_modify = "(".$user->id.")".$user->username." ".now();
                // 修改
                $form->input('last_modify', $last_modify);

            });

            $form->saved(function (Form $form) {

                $data = $form->updates();
//                dump($data);

            });

        });


    }
}
