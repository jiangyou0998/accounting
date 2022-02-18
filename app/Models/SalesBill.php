<?php

namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class SalesBill extends Model
{

    protected $table = 'sales_bills';
    public $timestamps = false;

    public static function getSalesBills()
    {
        $date = Carbon::now()->toDateString();
        $shop_id = Auth::user()->id;

        return self::query()
            ->where('date', $date)
            ->where('shop_id', $shop_id)
            ->get();
    }

}
