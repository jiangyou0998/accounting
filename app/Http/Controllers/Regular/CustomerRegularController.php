<?php

namespace App\Http\Controllers\Regular;


use App\Http\Controllers\Controller;
use App\Models\WorkshopOrderSample;
use App\User;
use Illuminate\Http\Request;

//外客範本
class CustomerRegularController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $shopid = $request->shopid;

        $shops = User::getCustomerShops();

        $sampleModel = new WorkshopOrderSample();
        $samples = $sampleModel
            ->select('id', 'sampledate','dept')
            ->where('user_id', $shopid)
            ->where('disabled', 0)
            ->get();

        foreach ($samples as $sample) {
            $sample->sampledate = $this->transSampleDate($sample->sampledate);

        }
//    dump($shops->toArray());

        return view('sample.regular', compact('samples','shops'));
    }

    private function transSampleDate($sampledate)
    {
        $weekArr = [
            '0' => '星期日',
            '1' => '星期一',
            '2' => '星期二',
            '3' => '星期三',
            '4' => '星期四',
            '5' => '星期五',
            '6' => '星期六',
        ];

        foreach ($weekArr as $key => $value) {
            //將數字轉換為星期
            $sampledate = str_replace($key, $value, $sampledate);
        }

        return $sampledate;
    }

}
