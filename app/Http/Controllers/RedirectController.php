<?php

namespace App\Http\Controllers;

class RedirectController extends Controller
{
    public function index($info)
    {
        $message = "";
        switch ($info) {
            case "ITSUPPORT_UPDATE_SUCCESS":
                $message = "IT維修「補充資料」提交成功!";
                $url = route('itsupport');
                break;

            case "REPAIR_UPDATE_SUCCESS":
                $message = "維修項目「補充資料」提交成功!";
                $url = route('repair');
                break;

            default:
                $message = "";
                break;
        }

        return view('redirect')->with(['message' => $message, 'url' => $url]);
    }
}
