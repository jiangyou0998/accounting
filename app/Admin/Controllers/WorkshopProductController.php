<?php

namespace App\Admin\Controllers;

//use App\Admin\Renderable\Price;
use App\Models\Price as PriceModel;
use App\Models\WorkshopGroup;
use App\Models\WorkshopUnit;
use App\Models\WorkshopProduct;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Controllers\AdminController;

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

            if(Admin::user()->can('factory-menus-edit') === false){
                // 禁用创建按钮
                $grid->disableCreateButton();
                // 禁用行操作按钮
                $grid->disableActions();
            }

            //2021-03-18 禁用詳情、刪除按鈕
            $grid->disableViewButton();
            $grid->disableDeleteButton();

            $grid->showQuickEditButton();

            // 表格快捷搜索
            $grid->quickSearch('product_no','product_name')
                ->placeholder('輸入「編號」或「名稱」快速搜索');

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
                $groupArr[$group['id']] = $group->toArray()['cats']['cat_name'].'-'.$group['group_name'];
            }

            //2021-02-19 價格數組
            $rbPricesArr = PriceModel::where('shop_group_id', 5)->get()->mapToGroups(function ($item, $key) {
                return [$item['product_id'] => $item];
            })->toArray();

            $grid->model()
                ->with(['cats'])
                ->with(['groups'])
                ->with(['units'])
                ->with(['prices'])
                ->where('status','<>', 4)
                ->orderBy('product_no');

            $grid->number();
            $grid->id()->sortable();
            $grid->product_no->sortable();
            $grid->product_name;
            $grid->column('units.unit_name',"單位");
//            $grid->price->display('View')->modal('Price', Price::make(['int_id' => $this->int_id]));
//            $grid->price->display('分組價格')->expand(function () {
//                // 允许在比包内返回异步加载类的实例
//                return Price::make(['id' => $this->id]);
//            });
            $grid->column('糧友價格')->display(function () use ($rbPricesArr) {
                return $rbPricesArr[$this->id][0]['price'] ?? '';
            })->badge('danger');

            $grid->column('cats.cat_name',"大類");
            $grid->column('groups.group_name',"細類");
            $grid->sort->sortable();

            //2020-12-30 狀態使用radio
            $grid->column('status')->radio([1 => '現貨', 2 => '暫停', 3 => '新貨', 5 => '季節貨']);

            $titles = [
                'product_no' => '編碼',
                'product_name' => '貨名',
                'group_id' => '細類',
                'unit_id' => '包裝' ,
                ];

            $titles['rb_price'] = '單價';
            $titles['rb_min'] = 'MOQ';

            $grid->export($titles)->rows(function (array $rows) use ($groupArr , $unitArr ,$rbPricesArr){
                foreach ($rows as $index => &$row) {
                    $row['group_id'] = $groupArr[$row['group_id']];
                    $row['unit_id'] = $unitArr[$row['unit_id']];
                    $row['rb_price'] = $rbPricesArr[$row['id']][0]['price'] ?? '';
                    $row['rb_min'] = $rbPricesArr[$row['id']][0]['min'] ?? '';
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

            $form->tools(function (Form\Tools $tools) {
                // 去掉跳转列表按钮
//                $tools->disableList();
                // 去掉跳转详情页按钮
                $tools->disableView();
                // 去掉删除按钮
                $tools->disableDelete();

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

            $form->select('','大類')->options('/api/cat')->load('group_id', '/api/group');

            $form->select('group_id')->options('/api/group2')->required();

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

            $products = WorkshopProduct::where('status','!=',4)->pluck('product_name','id');
//            dump($products);
            $form->select('base_product_id','關聯產品')->options($products);
            $form->text('change_rate','轉換比例')->rules('nullable|numeric');

            $form->display('last_modify');

            $form->hasMany('prices', '價格列表', function (Form\NestedForm $form) use($week){
                $form->select('shop_group_id', '商店分組')->options('api/shopgroup')->rules('required');
//                $form->text('shop_group_id', '商店分組')->rules('required');
                $form->text('price','單價')
                    ->rules('required|numeric|min:0.00')
                    ->required();
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
                    //正則匹配時間
                    ->rules(['regex:/([0-1]{1}[0-9]{1}|[2][0-3])[0-5]{1}[0-9]{1}/','size:4'])
                    ->required();
                $form->radio('phase','截單日期')
                    ->options([1 => '1日後',
                        2 => '2日後',
                        3 => '3日後',
                        4 => '4日後',
                        5 => '5日後',
                        6 => '6日後',
                        7 => '7日後',
                        -1 => '後勤落單'
                    ])
                    ->required();
                $form->checkbox('canordertime','出貨期')
                    ->options($week);

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
