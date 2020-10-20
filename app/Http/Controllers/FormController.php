<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;


class FormController extends Controller
{
    //
    public function index(Request $request)
    {
        $formModel = new Form();
        $dept = $request->dept;

        $forms = Form::getForms($dept);
//        $notices = $noticeModel
//            ->where('expired_date','>',now())
//            ->orderByDesc('modify_date')
//            ->get();

//        foreach ()

        $dept_names = Form::getDeptName();

//        dump($forms->toArray());
//        dump($dept_names->toArray());
        return view('forms.index',compact('forms','dept_names'));
    }
}
