<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalesCalResultRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'shop_id' => ['required'],
            'date' => ['required', 'date', 'before:today'],
        ];
    }

    public function messages()
    {
        return [
            'date.required' => '請選擇「時間」',
            'date.before' => '請選擇今天之前的時間',
        ];
    }
}
