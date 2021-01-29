<?php

namespace App\Admin\Controllers;

use App\Admin\Renderable\Checks\CheckCreate;
use App\Models\MyPage;
use App\Models\WorkshopCheck;
use Dcat\Admin\Admin;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Show;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\Input;

class WorkshopCheckController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new WorkshopCheck(), function (Grid $grid) {
            $grid->model()->orderBy('sort');
            $grid->id->sortable();
            $grid->report_name;
            $grid->num_of_day->display(function ($cutday) {
                return $cutday."日後";
            });
            $grid->int_hide->using([0 => '否', 1 => '是'])
                ->dot(
                [
                    0 => 'danger',
                    1 => 'success',
                ],
                'danger' // 默认颜色
            );
            $grid->sort;
//            $grid->disabled;

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
        return Show::make($id, new WorkshopCheck(), function (Show $show) {
            $show->id;
            $show->report_name;
            $show->int_hide;
            $show->sort;
            $show->disabled;
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
//    protected function form()
//    {
////        return Form::view('admin.pages.my-page');
////        return Form::make(new WorkshopCheck(), function (Form $form) {
////            $form->display('id');
////            $form->text('int_all_shop');
////            $form->text('shop_list');
////            $form->text('item_list');
////            $form->text('report_name');
////            $form->text('num_of_day');
////            $form->text('int_hide');
////            $form->text('int_main_item');
////            $form->text('sort');
////            $form->text('disabled');
////
////
////            $form->tools(function (Form\Tools $tools) {
////                $tools->append(new Product());
////            });
////
////            //選擇權限(樹狀插件)
////            $form->tree('permissions')
////                ->setTitleColumn('group_name')
////
////                ->nodes(function () {
////                    dump((new WorkshopProduct)->toTree());
////                    return ((new WorkshopProduct)->toTree());
////                })
////
////            ;
////
////            $menuModel = config('admin.database.menu_model');
////            $menuModel = new $menuModel;
////            $form->tree('form2.tree', 'tree')
////                ->setTitleColumn('title')
////                ->nodes(function () use ($menuModel) {
////                    dump($menuModel->allNodes());
////                    return $menuModel->allNodes();
////                });
////        });
//    }


    protected function form()
    {
        return Form::make(new WorkshopCheck(), function (Form $form) {

        });
    }

    public function create(Content $content)
    {

        return $content->body(new CheckCreate());
    }

    public function edit($id, Content $content)
    {

        return $content->body(new MyPage($id));
    }

    public function store()
    {
        dump(Input::all());

    }

    //todo 没做完
    public function createChecks(Request $request)
    {
//        $this->validate($request, [
//            'name' => 'required|max:50',
//            'password' => 'required|confirmed|min:6'
//        ]);

//        $request = Request::('report_info');

//        dump($request->report_info);

        $checks = new WorkshopCheck;

        $infos = json_decode($request->report_info);

//        dump($infos->hide);die();
//
//        $checks->int_all_shop = $infos->all_shop;

        $checks->item_list = implode(', ',$infos->item);
        $checks->report_name = $infos->name;
        $checks->num_of_day = $infos->num_of_day;
        $checks->int_hide = $infos->hide;
        $checks->int_main_item = $infos->mainItem;
        $checks->sort = $infos->sort;

        $printtime = array();
        $printtime['weekday'] = $infos->print_weekday;
        $printtime['time'] = $infos->print_time;

        // 数据库事务处理
        DB::transaction(function () use ($checks, $printtime) {
            $checks->save();
//            $checks->printtime->update($printtime);
        });



//
//        dump($checks->printtime);

//        $check->update([
//            'name' => $request->name,
//            'password' => bcrypt($request->password),
//        ]);

//        $url = admin_url('admin/checks');
//
//        Admin::script(
//            <<<JS
//        // 3秒后跳转到 admin/auth/users 页面
//        setTimeout(function () {
//            Dcat.reload('{$url}');
//        }, 3000);
//JS
//            );

//        Dcat.success('更新成功');
        return redirect('admin/checks');
    }

    //todo 没做完
    public function updateChecks($id, Request $request)
    {
//        $this->validate($request, [
//            'name' => 'required|max:50',
//            'password' => 'required|confirmed|min:6'
//        ]);

//        $request = Request::('report_info');

//        dump($request->report_info);

        $checks = WorkshopCheck::with('printtime')->find($id);

        $infos = json_decode($request->report_info);

//        dump($infos->hide);die();
//
//        $checks->int_all_shop = $infos->all_shop;

        $checks->item_list = implode(', ',$infos->item);
        $checks->report_name = $infos->name;
        $checks->num_of_day = $infos->num_of_day;
        $checks->int_hide = $infos->hide;
        $checks->int_main_item = $infos->mainItem;
        $checks->sort = $infos->sort;

        $printtime = array();
        $printtime['weekday'] = $infos->print_weekday;
        $printtime['time'] = $infos->print_time;

        // 数据库事务处理
        DB::transaction(function () use ($checks, $printtime) {
            $checks->save();
            $checks->printtime->update($printtime);
        });



//
//        dump($checks->printtime);

//        $check->update([
//            'name' => $request->name,
//            'password' => bcrypt($request->password),
//        ]);

//        $url = admin_url('admin/checks');
//
//        Admin::script(
//            <<<JS
//        // 3秒后跳转到 admin/auth/users 页面
//        setTimeout(function () {
//            Dcat.reload('{$url}');
//        }, 3000);
//JS
//            );

//        Dcat.success('更新成功');
        return redirect('admin/checks');
    }

}
