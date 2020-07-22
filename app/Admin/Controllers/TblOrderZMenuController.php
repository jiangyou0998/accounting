<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Tree\SelectShop;
use App\Admin\Repositories\TblOrderZMenu;
use App\Models\TblUser;
use App\Models\TblOrderCheck;
use App\Models\TblOrderZCat;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Models\Permission;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;


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

            $checks = new TblOrderCheck();

            $checkArr = array();

            foreach ($checks::all() as $check) {
                $menuIdArr = explode(',',$check->chr_item_list);
                foreach ($menuIdArr as $menu){
                    $tempArr =  explode(':', $menu);
                    $checkArr[$tempArr[1]] = $check->chr_report_name;
                }

            }

//            $menu = new \App\Models\TblOrderZMenu
//
//            dd($menu);

            $grid->model()
                ->with(['tblOrderZCat'])
                ->with(['tblOrderZGroup'])
                ->with(['tblOrderZUnit'])
                ->with(['price']);
            $grid->chr_no;
            $grid->chr_name;
            $grid->column('tblOrderZUnit.chr_name',"單位");
            $grid->int_base;
            $grid->int_min;
            $grid->int_default_price;
            $grid->column('tblOrderZCat.chr_name',"大類");
            $grid->column('tblOrderZGroup.chr_name',"細類");
            $grid->int_sort;
            $grid->chr_cuttime->label('danger');
            $grid->int_phase;
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

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('chr_cuttime');
                $filter->like('chr_name');
                $filter->equal('status')->select([1 => '現貨', 2 => '暫停', 3 => '新貨', 5 => '季節貨'])->default(1);
//                $filter->equal('tblOrderZCat.chr_name');
//                $filter->where('int_id', function ($query) {
//
//                    $query->whereHas('tblOrderZGroup', function ($query) {
//                        $query->where('int_id', 'like', "%{$this->input}%");
//                    });
//
//                }, '細類');

                $filter->where('int_group', function ($query) {

                    $query->whereHas('tblOrderZGroup', function ($query) {
                        $query->whereHas('tblOrderZCat', function ($query) {
                            $query->where('int_id', 'like', "%{$this->input}%");
                        });
                    });

                }, '大類');

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
        return Form::make(new TblOrderZMenu(), function (Form $form) {

//            $form->action($this->confirm1());
//
//            $form->model()
//                ->with(['tblOrderZCat'])
//                ->with(['tblOrderZGroup'])
//                ->with(['tblOrderZUnit'])
//                ->with(['tblUser'])
//                ->with(['price']);


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
            $form->text('chr_no')->required()->rules('required|max:7')
                ;

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

//            $form->tools(function (Form\Tools $tools) {
//                $tools->append(new SelectShop());
//            });

//            $form->selectResource('chr_sap', 'Select Resource(Multiple)')
//                ->path('users')
//                ->multiple();
//
//            $form->list('column_name')->max(10)->min(5);


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
