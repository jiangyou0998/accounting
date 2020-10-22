<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Form extends Model
{

    public $timestamps = false;

    public static function getForms($dept = null , $search = null)
    {
        $forms = new Form();

        if($dept != null){
            $forms = $forms->where('admin_role_id',$dept);
        }

        if($search != null){
            $forms = $forms
                ->where('form_name','like',"%".$search."%")
                ->orWhere('form_no','like',"%".$search."%");
        }

        $forms = $forms
            ->orderByDesc('modify_date')
            ->paginate(10);

        return $forms;
    }

    public static function getDeptName()
    {
        return Form::leftJoin('admin_roles','admin_roles.id','=','forms.admin_role_id')
            ->distinct()
            ->pluck('admin_roles.name','forms.admin_role_id');
    }

}
