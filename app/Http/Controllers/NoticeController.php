<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    //
    public function index(Request $request)
    {
        $dept = $request->dept;
        $search = $request->search;

        $notices = Notice::getNotices($dept , $search);

        $dept_names = Notice::getDeptName();

//        dump($notices->toArray());
//        dump($dept_names->toArray());
        return view('notices.index',compact('notices','dept_names'));
    }

    public function attachment($id)
    {

        $notice = Notice::getNoticesAttachment($id);

//        dump($notice->toArray());

        return view('notices.attachment',compact('notice'));
    }
}
