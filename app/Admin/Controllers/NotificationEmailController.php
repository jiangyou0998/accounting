<?php

namespace App\Admin\Controllers;

use App\Models\NotificationEmail;
use App\User;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class NotificationEmailController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new NotificationEmail(), function (Grid $grid) {
            $grid->model()->isTest();
            $grid->column('id')->sortable();
            $grid->column('name');
            $grid->column('email');
            $grid->column('type');

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');

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
        return Show::make($id, new NotificationEmail(), function (Show $show) {
            $show->field('id');
            $show->field('name');
            $show->field('email');
            $show->field('type');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new NotificationEmail(), function (Form $form) {
            $form->display('id');
            $form->text('name');
//            $emails = User::whereNotNull('email')->distinct('email')->orderBy('email')->get()
//                ->map(function (User $user) {
//                    return [
//                        'email' => $user->email,
//                        'text' => $user->txt_name. '-' . $user->email,
//                    ];
//                })->pluck('text', 'email');
//            $form->select('email')->options($emails);
            $form->email('email');
            $form->text('type');
            $form->hidden('is_test');

            $form->submitted(function (Form $form) {

                $is_test = isTestEnvironment();

                $form->input('is_test', $is_test);

            });
        });
    }
}
