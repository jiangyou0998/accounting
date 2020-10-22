<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;


class NoticeController extends Controller
{
    //
    public function index(Request $request)
    {
        $noticeModel = new Notice();
        $dept = $request->dept;
        $search = $request->search;
//        dump($search);

        $notices = Notice::getNotices($dept , $search);
//        $notices = $noticeModel
//            ->where('expired_date','>',now())
//            ->orderByDesc('modify_date')
//            ->get();

//        foreach ()

        $dept_names = Notice::getDeptName();

//        dump($notices->toArray());
//        dump($dept_names->toArray());
        return view('notices.index',compact('notices','dept_names'));
    }
}
