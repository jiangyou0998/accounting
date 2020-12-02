<?php

namespace App\Http\Controllers;

class RedirectController extends Controller
{
    public function index($info)
    {
        $message = "";
        switch ($info) {
            case "ITSUPPORT_UPDATE_SUCCESS":   //强制登出
                $message = "IT維修「補充資料」提交成功!";
                $url = route('itsupport');
                break;
            default:
                $message = "";
                break;
        }

        return view('redirect')->with(['message' => $message, 'url' => $url]);
    }
}
