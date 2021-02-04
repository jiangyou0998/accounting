<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Notice;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
////        $this->middleware('auth');
//    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $notices = Notice::getNoticesForHome();

        foreach ($notices as &$notice){
            $notice->isNew = false;
            $modify_date = Carbon::parse($notice->updated_at);
            $now = Carbon::now();

            //七日內是新
            if($now->diffInDays($modify_date,false) > -7){
                $notice->isNew = true;
            }
        }
        $dept_names = Notice::getDeptName();
//        dump($notices);
        return view('home.home',compact('notices','dept_names'));
    }
}
