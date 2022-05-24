<?php

namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class SalesDataChangeApplication extends Model
{
    const STATUS_APPLYING = 0;
    const STATUS_APPROVED = 1;
    const STATUS_REJECTED = 2;

    protected $table = 'sales_data_change_applications';

    public static function applicationSubmit($date, $shop_id){

        //檢查是否已經生成單
        $sales_cal_result = SalesCalResult::query()
            ->where('date', $date)
            ->where('shop_id', $shop_id)
            ->first();

        if (! $sales_cal_result){
            throw new \ErrorException('當日沒有填寫營業數!');
        }

        $sales_data_change_applications = self::query()
            ->where(function ($query) use($date, $shop_id){
                return $query->where('date', $date)
                    ->where('shop_id', $shop_id)
                    ->where('status', self::STATUS_APPLYING);
            })
            ->orWhere(function ($query) use($date, $shop_id){
                return $query->whereDate('date', $date)
                    ->where('shop_id', $shop_id)
                    ->whereDate('handle_date', now())
                    ->where('status', '!=', self::STATUS_APPLYING);
            })
            ->first();

        if ($sales_data_change_applications){
            throw new \ErrorException('請勿重複提交申請!');
        }

        $now = Carbon::now()->toDateTimeString();
        $data = [
            'date' => $date,
            'shop_id' => $shop_id,
            'status' => self::STATUS_APPLYING,
            'created_at' => $now,
            'updated_at' => $now,
        ];

        self::insert($data);
    }

}
