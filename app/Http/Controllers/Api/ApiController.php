<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    //
    public function resetAllPassword(){
        //批量修改密碼
        $newPassword = 'xm95jw';

        User::where('id','>',0)
            ->update(['password' => Hash::make($newPassword)]);
    }

    public function resetAdminAllPassword(){
        //批量修改密碼
        $newPassword = 'z32c4f';

        DB::table('admin_users')->where('id','>',0)
            ->update(['password' => Hash::make($newPassword)]);
    }

    public function resetShopPassword(){
        //批量修改密碼
        $users = User::with('address')
            ->where('name','like','kb%')
            ->orWhere('name','like','ces%')
            ->orWhere('name','like','b&b%')
            ->get();

        foreach ($users as &$user){
            if(isset($user->address->tel)){
                $name = $user->name;
                $tel = substr($user->address->tel,-4);
                $newPassword = $name.$tel;
                User::where('id','=',$user->id)
                    ->update(['password' => Hash::make($newPassword)]);
            }
        }

//        dd($users->toArray());


    }
}
