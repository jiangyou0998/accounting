<?php

namespace App\Http\Requests;

use App\Models\Repairs\RepairProject;
use Illuminate\Foundation\Http\FormRequest;

class RepairOrderRequest extends FormRequest
{
    public function rules()
    {
        return [
            'items'  => ['required', 'array'],
            'items.*.id' => [ // 检查 items 数组下每一个子数组的 id 参数
                'required',
                function ($attribute, $value, $fail) {
                    if (!$repair_project = RepairProject::find($value)) {
                        return $fail('有項目不存在');
                    }

                    if ($repair_project->status !== 1) {
                        return $fail('有項目不為未完成項目，請重新開單');
                    }

                },
            ],
            //完成日期
            'complete_date' => 'required|date',
            //到店時間（時）
            'start_hour' => ['required', 'regex:/^(0?[0-9]|1[0-9]|2[0-3])$/'],
            //到店時間（分）
            'start_minute' => ['required', 'regex:/^(0?[0-9]|[1-5][0-9])$/'],
            //離開時間（時）
            'end_hour' => ['required', 'regex:/^(0?[0-9]|1[0-9]|2[0-3])$/'],
            //離開時間（分）
            'end_minute' => ['required', 'regex:/^(0?[0-9]|[1-5][0-9])$/'],
            //維修員
            'handle_staff' => 'required',
            //維修費用
            'fee' => 'required|numeric|min:0',
        ];
    }

    public function messages()
    {
        return [
            'complete_date.required' => '請填寫「完成日期」。',
            'complete_date.date' => '「完成日期」請填寫正確的日期。',

            'start_hour.required' => '請填寫「到店時間（時）」。',
            'start_hour.regex' => '「到店時間（時）」請輸入正確的格式（00-23）。',

            'start_minute.required' => '請填寫「到店時間（分）」。',
            'start_minute.regex' => '「到店時間（分）」請輸入正確的格式（00-59）。',

            'end_hour.required' => '請填寫「離開時間（時）」。',
            'end_hour.regex' => '「離開時間（時）」請輸入正確的格式（00-23）。',

            'end_minute.required' => '請填寫「離開時間（分）」。',
            'end_minute.regex' => '「離開時間（分）」請輸入正確的格式（00-59）。',

            'handle_staff.required' => '請填寫「維修員」。',

            'fee.required' => '請填寫「維修費用」。',
            'fee.numeric' => '「維修費用」請輸入數字。',
            'fee.min' => '「維修費用」必須大於0。',
        ];
    }
}
