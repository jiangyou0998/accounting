<?php

namespace App\Http\Controllers;


use App\Models\Itsupport\ItsupportItem;
use Illuminate\Http\Request;


class ItSupportController extends Controller
{
    //
    public function index(Request $request)
    {
        $items = ItsupportItem::all()->pluck('name','id');

        $details = ItsupportItem::with('details')->get()->mapToGroups(function ($item, $key) {
            return [$item['id'] => $item['details']->pluck('name','id')];
        });



//        foreach ($items as $item)

//        dump($items->toArray());

        return view('support.itsupport.index',compact('items','details'));
    }
}
