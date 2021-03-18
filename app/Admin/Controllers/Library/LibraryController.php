<?php

namespace App\Admin\Controllers\Library;

use App\Admin\Actions\Library\BatchRestore;
use App\Admin\Actions\Library\Restore;
use App\Admin\Renderable\KBShopTable;
use App\Admin\Renderable\UserTable;
use App\Models\FrontGroup;
use App\Models\Library\Library;
use App\Models\Library\LibraryGroup;
use App\User;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Models\Administrator;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
use Spatie\Permission\Models\Role;

class LibraryController extends AdminController
{

    protected $options = [
        'FILE' => '文件上传',
        'LINK' => '鏈接',
    ];

    protected $viewTypeOptions = [
        'GROUP' => '分組',
        'SHOP' => '分店',
    ];

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $library = new Library();

        return Grid::make($library, function (Grid $grid) {

            $grid->column('id')->sortable();
            $grid->column('name');
            $grid->column('library_type');
            $grid->column('file_name');
            $grid->column('file_path');
            $grid->column('link_name');
            $grid->column('link_path');

            //回收站恢復
            $grid->actions(function (Grid\Displayers\Actions $actions) {
                if (request('_scope_') == 'trashed') {
                    $actions->append(new Restore(Library::class));
                }
            });

            //回收站批量恢復
            $grid->batchActions(function (Grid\Tools\BatchActions $batch) {
                if (request('_scope_') == 'trashed') {
                    $batch->add(new BatchRestore(Library::class));
                }
            });

            $grid->filter(function (Grid\Filter $filter) {
                // 更改为 panel 布局
                $filter->panel();
                $filter->equal('group_id','圖書分類')->select(LibraryGroup::selectOptionsWithoutMain());
                // 范围过滤器，调用模型的`onlyTrashed`方法，查询出被软删除的数据。
                $filter->scope('trashed', '回收站')->onlyTrashed();
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
        return Show::make($id, new Library(), function (Show $show) {
            $show->field('id');
            $show->field('name');
            $show->field('library_type');
            $show->field('file_path');
            $show->field('file_name');
            $show->field('link_path');
            $show->field('link_name');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $builder = new Library();
        $builder = $builder->with(['users','frontgroups']);


//        dump(Role::with('users')->get()->toArray());
//        dump(User::with('roles')->get()->toArray());
//        dump(Library::with('users')->get()->toArray());

        return Form::make($builder, function (Form $form){
            $form->display('id');
            $form->text('name')->required();

            $form->select('group_id', '分組')->options(function () {
                return LibraryGroup::selectOptionsWithoutMain();
            })->saving(function ($v) {
                return (int) $v;
            })->required();

            $form->radio('library_type')
                ->when('FILE', function (Form $form) {
                    $form->text('file_name');
                    $form->file('file_path')
                        ->disk('library')
                        ->accept('xls,xlsx,csv,pdf,mp4,mov,jpg,jpeg,png')
                        ->uniqueName()
                        ->maxSize(204800)
                        ->autoUpload();
                })
                ->when('LINK', function (Form $form) {
                    $form->text('link_name');
                    $form->url('link_path');
                })
                ->options($this->options)
                ->default('FILE')->required();

//            dump(LibraryGroup::selectOptions());


            $form->radio('view_type','可視設定')
                ->when('GROUP', function (Form $form) {
                    $form->tree('frontgroups','分組')
                        ->nodes(function () {
                            return FrontGroup::get(['id','name'])->toArray();
                        })
                        ->setTitleColumn('name')
                        ->customFormat(function ($v) {
                            if (!$v) return [];

                            // 这一步非常重要，需要把数据库中查出来的二维数组转化成一维数组
                            return array_column($v, 'id');
                        });
//                    $form->hidden('users');

                })
                ->when('SHOP', function (Form $form) {

                    $form->tree('users','分店')
                        ->nodes(function () {
                            return User::where('name','like','kb%')->get(['id','txt_name'])->toArray();
                        })
                        ->setTitleColumn('txt_name')
                        ->customFormat(function ($v) {
                            if (!$v) return [];

                            // 这一步非常重要，需要把数据库中查出来的二维数组转化成一维数组
                            return array_column($v, 'id');
                        });
//                    $form->hidden('frontgroups');
                })

                ->options($this->viewTypeOptions)
                ->default('GROUP')->required();

            //todo 處理多餘數據
            //選分組時,分店數據變為空
            $form->submitted(function (Form $form) {

                //選擇一個分組時.另一個分組數據變成''
                if($form->view_type == 'GROUP'){
                    $form->input('users','');
                }elseif ($form->view_type == 'SHOP'){
                    $form->input('frontgroups','');
                }



            });

        });
    }
}
