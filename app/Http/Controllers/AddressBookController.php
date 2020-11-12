<?php

namespace App\Http\Controllers;

use App\Models\ShopGroup;
use Illuminate\Http\Request;

class AddressBookController extends Controller
{
    //
    public function index(Request $request)
    {
        $shop_groups = ShopGroup::has('users')->pluck('name','id');

        $shop_addresses = ShopGroup::has('users')
            ->with('users_with_addresses');

        if(isset($request->group)){
            $shop_addresses = $shop_addresses->where('id',$request->group);
        }

        $shop_addresses = $shop_addresses->get();

//        dump($shop_groups);

        return view('addressbook.index',compact('shop_addresses','shop_groups'));
    }
}
