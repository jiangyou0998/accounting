<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class DeliveryController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();
        if($user->can('operation')){
            return redirect(route('order.deli.list'));
        }

        $infos = new Collection();
        $infos->deli_date = Carbon::now()->toDateString();
        $infos->user_id = $user->id;

        return view('delivery.index',compact('infos'));
    }
}
