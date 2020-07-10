<?php

namespace App\Http\Controllers;

use App\Exports\TotalByShopExport;
use App\Models\OrderZDept;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class OrderZDeptController extends Controller
{
    public function export()
    {
//        dd(OrderZDept::all()->toArray());
        return Excel::download(new TotalByShopExport, 'total.xlsx');
    }
}
