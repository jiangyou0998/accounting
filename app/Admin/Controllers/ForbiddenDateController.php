<?php

namespace App\Admin\Controllers;

use App\Models\ForbiddenDate;
use App\Models\ShopGroup;
use App\Models\WorkshopCat;
use App\User;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Widgets\Alert;
use Dcat\Admin\Widgets\Card;

class ForbiddenDateController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new ForbiddenDate(), function (Grid $grid) {

            $grid->header(function ($collection) {
                $alertText = '注意！此頁面為禁止下單頁面。禁止下單優先級高於特別下單！';
//                $grid->html(Alert::make($alertText, '提示')->info());
                $card = Card::make('', Alert::make($alertText, '提示')->danger());

                return $card;
            });

            $grid->disableViewButton();

            $grid->model()->latest('id');

            $grid->column('id')->sortable();


            $catArr = WorkshopCat::all()->pluck('cat_name','id')->toArray();
            $grid->column('cat_ids')->explode()->map(function ($item, $key) use ($catArr){
                return $catArr[$item] ?? $item;
            })->label('danger');

            $userArr = User::all()->pluck('report_name','id')->toArray();
            $grid->column('user_ids')->explode()->map(function ($item, $key) use ($userArr){
                return $userArr[$item] ?? $item;
            })->label();

            $grid->column('forbidden_date');

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
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
        return Form::make(new ForbiddenDate(), function (Form $form) {
            $form->checkbox('cat_ids')->options(WorkshopCat::all()->pluck('cat_name','id'))->required();
//            $form->checkbox('user_ids')->options(User::getAllShopsByShopGroup()->pluck('txt_name', 'id'))->required();
            $shopGroupIds = ShopGroup::has('users')
                ->whereIn('id',[ShopGroup::KB_SHOP_ID, ShopGroup::TWOCAFE_SHOP_ID, ShopGroup::RB_SHOP_ID, ShopGroup::LAGARDERE_SHOP_ID])
                ->pluck('name','id')
                ->toArray();
            foreach ($shopGroupIds as $shopGroupId => $shopGroupName){
                $form->checkbox('user_ids',$shopGroupName)
                    ->canCheckAll()
                    ->options(User::getShopsByShopGroup($shopGroupId)->pluck('report_name', 'id'));
            }
            $form->date('forbidden_date')->required();
        });
    }
}
