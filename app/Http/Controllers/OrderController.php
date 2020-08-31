<?php

namespace App\Http\Controllers;


use App\Models\Menu;

class OrderController extends Controller
{


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $menus = Menu::with('allChildrenMenu')->get();
        return view('order.index',compact('menus'));
    }

    public function select_day()
    {
        $menus = Menu::with('allChildrenMenu')->get();
        return view('order.select_day',compact('menus'));
    }
}
