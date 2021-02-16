<?php

namespace App\Admin\Controllers;

use App\User;
use Carbon\Carbon;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Widgets\Card;

class LastLoginController extends AdminController
{
    public function index(Content $content)
    {
        return $content
            ->header('最近一分鐘活躍用戶')
            ->body($this->grid());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(null, function (Grid $grid) {

            $grid->header(function ($collection) {
                $date = Carbon::now()->toDateTimeString();

                $card = Card::make('生成時間:', $date);

                return $card;
            });

            // 禁用行选择器
            $grid->disableRowSelector();
            $grid->disableCreateButton();
            $grid->disableActions();
            $grid->disableBatchDelete();
            $grid->disablePagination();

            $data = $this->generate();
            // 设置表格数据
            $grid->model()->setData($data);

            // 表格內容
            $grid->column('id')->sortable();
            $grid->column('txt_name','用戶名')->sortable();

        });
    }

    /**
     * 生成数据
     *
     * @return array
     */
    public function generate()
    {
        $users = User::all();

        foreach ($users as $key => $user){
            if(!$user->isOnline()){
                $users->forget($key);
            }
        }

        return $users;

    }

}
