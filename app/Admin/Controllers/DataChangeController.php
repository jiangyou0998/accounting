<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\Notice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DataChangeController extends Controller
{
    public function index(){
        return view('admin.datachange.index');
    }


    public function test()
    {
        $noticeModel = new Notice();

        $notices = $noticeModel->all();

        $oldDept = DB::table('tbl_dept')->pluck('txt_dept','int_id');
        $newDept = DB::table('admin_roles')->pluck('id','name');
        $oldUser = DB::table('users')->pluck('txt_name','id');
        $newUser = DB::table('admin_users')->pluck('id','name');


        foreach ($notices as &$notice){
            if($notice->file_path) {
                $notice->file_path = 'files/'.Str::after($notice->file_path,'./notice/');
            }

            if(isset($oldDept[$notice->admin_role_id])){
                if(isset($newDept[$oldDept[$notice->admin_role_id]])){
                    $notice->admin_role_id = $newDept[$oldDept[$notice->admin_role_id]];
                }
            }

            if(isset($oldUser[$notice->user_id])){
                if(isset($newDept[$oldUser[$notice->user_id]])){
                    $notice->admin_role_id = $newUser[$oldUser[$notice->user_id]];
                }
            }

            if(is_null($notice->expired_date)){
                $notice->expired_date = "9999-12-31";
            }

            $notice->first_path = null;
//            dump($notice->toArray());
            $notice->save();
        }

//        $noticeModel->save($notices->toArray());

//        dump($oldDept);
//        dump($newDept[$oldDept]);
//        dump($oldUser);
//        dump($newUser);
        dump($notices->toArray());
    }

    public function changeForms()
    {
        $formModel = new Form();

        $forms = $formModel->all();

        $oldDept = DB::table('tbl_dept')->pluck('txt_dept','int_id');
        $newDept = DB::table('admin_roles')->pluck('id','name');
        $oldUser = DB::table('users')->pluck('txt_name','id');
        $newUser = DB::table('admin_users')->pluck('id','name');


        foreach ($forms as &$form){
            if($form->file_path) {
                $form->file_path = 'files/'.Str::after($form->file_path,'./notice/');
            }

            if(isset($oldDept[$form->admin_role_id])){
                if(isset($newDept[$oldDept[$form->admin_role_id]])){
                    $form->admin_role_id = $newDept[$oldDept[$form->admin_role_id]];
                }
            }

            if(isset($oldUser[$form->user_id])){
                if(isset($newDept[$oldUser[$form->user_id]])){
                    $form->admin_role_id = $newUser[$oldUser[$form->user_id]];
                }
            }

            $form->sample_path = null;
            $form->first_path = null;
//            dump($form->toArray());
            $form->save();
        }

//        $formModel->save($forms->toArray());

//        dump($oldDept);
//        dump($newDept[$oldDept]);
//        dump($oldUser);
//        dump($newUser);
        dump($forms->toArray());
    }


}
