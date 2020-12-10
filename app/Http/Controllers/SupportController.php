<?php

namespace App\Http\Controllers;


class SupportController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('support.index');
    }


}
