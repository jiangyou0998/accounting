<?php

namespace App\Admin\Controllers;

use App\Models\ShopGroup;
use App\User;
use Dcat\Admin\Admin;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Widgets\Alert;
use Illuminate\Support\Facades\Hash;

class ShopUserController extends AdminController
{
    protected $login_disabled = [0 => '啟用', 1 => '禁用'];
    protected $title = '外客用戶管理';

    protected function grid()
    {
        return Grid::make(new User(), function (Grid $grid) {
            $grid->showQuickEditButton();

            //非管理員禁止刪除
            if(!Admin::user()->isAdministrator()){
                $grid->disableDeleteButton();
            }

            $grid->model()->has('shop_groups')->whereHas('shop_groups', function ($query){
                $query->customerShop();
            });

            //快速搜索
            $grid->quickSearch('name', 'txt_name');

            $grid->id->sortable();
            $grid->name->sortable();
            $grid->column('pocode', '編號');
            $grid->column('txt_name', '分店名稱');
            $grid->column('report_name', '報告名稱');
            $grid->column('company_chinese_name','公司名(中文)')->hide();
            $grid->column('company_english_name','公司名(英文)')->hide();
            $grid->column('sort', '排序')->sortable();
            $grid->column('login_disabled','賬號登錄')
                ->using($this->login_disabled)
                ->dot(
                    [
                        0 => 'success',
                        1 => 'danger',
                    ],
                    'success' // 默认颜色
                );

            $grid->filter(function (Grid\Filter $filter) {
                $rolesModel = config('front.database.roles_model');
                $roles = $rolesModel::all()->pluck('name','name');
                $filter->like('name','登錄名');
                $filter->like('txt_name','名稱');
                $filter->equal('roles.name','角色')->select($roles);
                $filter->equal('login_disabled','賬戶登錄')->select($this->login_disabled);

            });

            //2021-05-05 價格分組數組
            $shopGroupArr = ShopGroup::orderBy('sort')->customerShop()->pluck('name', 'id');

            //選擇器
            $grid->selector(function (Grid\Tools\Selector $selector) use($shopGroupArr){

                $selector->selectOne('shop_group', '分組', $shopGroupArr, function ($query, $value) {
//                    $value = current($value);
                    $query->whereHas('shop_groups', function ($query) use($value){
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
        $user = User::with('roles')
            ->with('shop_groups')
            ->with('address');
        return Form::make($user, function (Form $form) {
            if(!Admin::user()->isAdministrator()){
                $form->tools(function (Form\Tools $tools) {
                    // 去掉`查看`按钮
                    $tools->disableDelete();
                });
            }

            $form->display('id');
            $id = $form->getKey();

            //2021-05-17 新增提示
            $alertText = '登入名稱請以「cu」開頭！';
            $form->html(Alert::make($alertText, '提示')->info());
            $form->text('name', '登入名稱(英文)')->required()->rules("required|
                unique:users,name,{$form->getKey()},id", [
                'unique'   => '用戶名已存在',
            ]);
            $form->text('pocode','商店編號');
            $form->text('txt_name', '分店名稱')->required();
            $form->text('report_name', '報告名稱')->required();

            $form->email('email');
            //2021-05-17 新增提示
            $alertText = '排序不填寫時將自動以最大值寫入！';
            $form->html(Alert::make($alertText, '提示')->info());
            $form->text('sort','報表排序');
            $form->text('company_chinese_name','公司名(中文)');
            $form->text('company_english_name','公司名(英文)');

            $form->radio('login_disabled', '賬戶登錄')
                ->options($this->login_disabled)
                ->required()
            ->default(1);

//            $form->multipleSelect('shop_groups','價格分組')
//                ->options(ShopGroup::all()->pluck('name', 'id'))
//                ->customFormat(function ($v) {
//                    if (! $v) {
//                        return [];
//                    }
//
//                    // 从数据库中查出的二维数组中转化成ID
//                    return array_column($v, 'id');
//                })
//                ->required();

            //選擇角色
            $form->selectResource('shop_groups', '價格分組')
                ->path('shopgroup') // 设置表格页面链接
//                ->multiple() // 设置为多选
                ->required()
                ->options(function () { // 显示已选中的数据

                    $v = ShopGroup::all()->pluck('name','id')->toArray();

                    return $v;
                })->customFormat(function ($v) {
                    if (!$v) return [];
                    return array_column($v, 'id');
                });

            $form->divider();
            $form->text('address.shop_name','分店名');
            $form->text('address.address','地址');
            $form->text('address.eng_address','英文地址');
            $form->text('address.tel','電話');
            $form->text('address.fax','FAX');
            $form->text('address.oper_time','營業時間');
            $form->divider();

            $form->hidden('password');

            $form->saving(function (Form $form) {
                // 判断是否是新增操作
                if ($form->isCreating()) {
                    $form->deleteInput('radio');
                    $password = 'xm95jw';
                    $form->input('password', Hash::make($password));
                }

                $password = $form->input('password');
                if ($password){
                    // 加密
                    $form->input('password', Hash::make($password));
                }else{
                    $form->deleteInput('password');
                }

                $sort = $form->input('sort');
                if ( ! $sort){
                    // 獲取最大排序+1
                    $sort = User::max('sort') + 1;
                    $form->input('sort', $sort);
                }

                // 删除用户提交的数据
                $form->deleteInput('password_confirm');

            });

            //保存完後刷新權限
            $form->saved(function (Form $form, $result) {
                $user = new \App\User();
                $user->syncPermissions([]);
            });
        });
    }
}
