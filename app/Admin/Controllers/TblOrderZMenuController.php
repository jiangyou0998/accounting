<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Tree\SelectShop;
use App\Admin\Repositories\TblOrderZMenu;
use App\Models\TblOrderZGroup;
use App\Models\TblOrderZUnit;
use App\Models\TblUser;
use App\Models\TblOrderCheck;
use App\Models\TblOrderZCat;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Models\Permission;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
use Illuminate\Support\Collection;
use App\Admin\Renderable\Price;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class TblOrderZMenuController extends AdminController
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


        return Grid::make(new TblOrderZMenu(), function (Grid $grid) {


            if(Admin::user()->can('factory-menus') === false){
                // 禁用创建按钮
                $grid->disableCreateButton();
                // 禁用行操作按钮
                $grid->disableActions();
            }

            $grid->showQuickEditButton();

            // 表格快捷搜索
            $grid->quickSearch('chr_no','chr_name')
                ->placeholder('輸入「編號」或「名稱」快速搜索');


            //生產表數組
            $checks = new TblOrderCheck();

            $checkArr = array();

            foreach ($checks::all() as $check) {
                $menuIdArr = explode(',',$check->chr_item_list);
                foreach ($menuIdArr as $menu){
                    $tempArr =  explode(':', $menu);
                    $checkArr[$tempArr[1]] = $check->chr_report_name;
                }

            }

            //單位數組
            $units = new TblOrderZUnit();

            $unitArr = array();
            foreach ($units::all() as $unit) {
                $unitArr[$unit['int_id']] =  $unit['chr_name'];
            }


            //細類數組
            $groups = new TblOrderZGroup();

            $groupArr = array();
            $groups = $groups::with('tblOrderZCat')->get();
            foreach ($groups as $group) {
//                dump($group->toArray()['tbl_order_z_cat']);
                $groupArr[$group['int_id']] = $group->toArray()['tbl_order_z_cat']['chr_name'].'-'.$group['chr_name'];
            }


//            dd($groupArr);


//            $menu = new \App\Models\TblOrderZMenu
//
//            dd($menu);

            $grid->model()
                ->with(['tblOrderZCat'])
                ->with(['tblOrderZGroup'])
                ->with(['tblOrderZUnit'])
                ->with(['price'])
                ->where('status','<>', 4);

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
            $grid->chr_no->sortable();
            $grid->chr_name;
            $grid->int_base;
            $grid->int_min;
            $grid->column('tblOrderZUnit.chr_name',"單位");
            $grid->int_default_price;
//            $grid->price->display('View')->modal('Price', Price::make(['int_id' => $this->int_id]));
            $grid->price->display('分組價格')->expand(function () {
                // 允许在比包内返回异步加载类的实例
                return Price::make(['int_id' => $this->int_id]);
            });

            $grid->column('tblOrderZCat.chr_name',"大類");
            $grid->column('tblOrderZGroup.chr_name',"細類");
            $grid->int_sort;
            $grid->chr_cuttime->label('danger');
            $grid->int_phase->display(function ($phase) {

                if($phase > 0){
                    return $phase."日後";
                }else{
                    return "<span style='color:red'>後勤落單</span>";
                }


            });
//            $grid->int_phase;

            $grid->status->using([1 => '現貨', 2 => '暫停', 3 => '新貨', 5 => '季節貨'])
                ->dot(
                    [
                        1 => 'success',
                        2 => 'danger',
                        3 => 'primary',
                        4 => Admin::color()->info(),
                    ],
                    'success' // 默认颜色
                );
            $grid->column('chr_canordertime','出貨期');

            $grid->column('所屬生產表')->display(function () use ($checkArr) {
                if (isset($checkArr[$this->int_id])){
                    return $checkArr[$this->int_id];
                }else{
                    return "不在生產表中";
                }

            });



//            $grid->column('price')->pluck('price','id')->map('ucwords');



//            $grid->prices->display(function ($prices) use ($grid){
//                foreach ($prices as $price){
//                    $grid->column('')->values($price['price']);
//                }
////                $count = count($prices);
////
////                return "<span>{$count}</span>";
//
//            });;

            // 禁用分頁
//            $grid->disablePagination();
            $titles = [
                'chr_no' => '編碼',
                'chr_name' => '貨名',
                'int_group' => '細類',
                'int_min' => 'MOQ',
                'int_unit' => '包裝' ,
                'int_default_price' => '單價'];
            $grid->export($titles)->rows(function (array $rows) use ($groupArr , $unitArr){
                foreach ($rows as $index => &$row) {
                    $row['int_group'] = $groupArr[$row['int_group']];
                    $row['int_unit'] = $unitArr[$row['int_unit']];
                }

                return $rows;
            });

            //------------------------------------------------------------------
            //過濾器
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('chr_cuttime');
                $filter->like('chr_name');
                $filter->like('chr_no');
                $filter->equal('status')->select([1 => '現貨', 2 => '暫停', 3 => '新貨', 5 => '季節貨']);
//                $filter->equal('tblOrderZCat.chr_name');
//                $filter->where('int_id', function ($query) {
//
//                    $query->whereHas('tblOrderZGroup', function ($query) {
//                        $query->where('int_id', 'like', "%{$this->input}%");
//                    });
//
//                }, '細類');

                $filter->where('int_cat', function ($query) {

                    $query->whereHas('tblOrderZGroup', function ($query) {
                        $query->whereHas('tblOrderZCat', function ($query) {
                            $query->where('int_id', '=', $this->input);
                        });
                    });

                }, '大類')->select('api/cat')->load('int_group', '/api/group');

                $filter->where('int_group', function ($query) {

                    $query->whereHas('tblOrderZGroup', function ($query) {
                        $query->where('int_id', '=', $this->input);
                    });

                }, '細類')->select('api/group2')->default("");



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
        return Show::make($id, new TblOrderZMenu(), function (Show $show) {
            $show->int_id;
            $show->chr_name;
            $show->chr_no;
            $show->int_group;
            $show->int_unit;
            $show->int_base;
            $show->int_min;
            $show->int_default_price;
            $show->int_sort;
            $show->chr_cuttime;
            $show->int_phase;
            $show->status;
            $show->chr_sap;
            $show->chr_sap_2;
            $show->int_unit_2;
            $show->chr_image;
            $show->txt_detail_1;
            $show->txt_detail_2;
            $show->txt_detail_3;
            $show->last_modify;
            $show->chr_canordertime;
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $builder = new TblOrderZMenu();
        $builder = $builder->with('price');

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




            $form->display('int_id',"ID");
            $form->text('chr_name')->required();
            $form->text('chr_no')->required()->rules("required|
                max:7|unique:tbl_order_z_menu,chr_no,{$form->getKey()},int_id", [
                    'max' => '編號最大長度為7',
                    'unique'   => '編號已存在',
                ]);
//                ;
//            $form->text('chr_no')->required()->rules(function ($form) {
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

            $form->select('','大類')->options('/api/cat')->load('int_group', '/api/group');

            $form->select('int_group')->options('/api/group2')->required();
//            $form->text('int_group')->required();




            $form->select('int_unit')->options('/api/unit');
//            $form->number('int_base')->required();
            $form->text('int_base')
                ->type('number')
                ->attribute('min', 0)
                ->required();
            $form->text('int_min')
                ->type('number')
                ->attribute('min', 0)
                ->required();
//            $form->text('int_default_price')->required();
            $form->currency('int_default_price')->symbol('$')->required();
            $form->text('int_sort')
                ->type('number')
                ->required();
            $form->text('chr_cuttime')
                ->type('number')
                ->attribute('min', 0)
                ->required();
            $form->text('int_phase')
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
            $form->checkbox('chr_canordertime')
                ->options($week)
                ->required()
                ->saving(function ($value) {
                    // 转化成json字符串保存到数据库
                    return implode(",",$value);
                });

            $form->display('last_modify');


            $form->hasMany('price', '價格列表', function (Form\NestedForm $form) {
                $form->select('shop_group_id', '商店分組')->options('api/shopgroup')->rules('required');
//                $form->text('shop_group_id', '商店分組')->rules('required');
                $form->text('price', '单价')->rules('required|numeric|min:0.01');
            });


            $form->saving(function (Form $form) {

                $user = Admin::user();
                $last_modify = "(".$user->id.")".$user->username." ".now();
                // 修改
                $form->input('last_modify', $last_modify);

                $form->deleteInput('chr_sap');

            });

            $form->saved(function (Form $form) {

                $data = $form->updates();
//                dump($data);

            });

        });


    }



}
