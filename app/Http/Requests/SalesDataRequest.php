<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalesDataRequest extends FormRequest
{

    public function rules()
    {
        return [
            'inputs.0.*' => ['nullable', 'numeric', 'min:0'],
            'first_pos_no' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function messages()
    {
        return [

            'inputs.0.*.numeric' => '請輸入正確的數字'
        ];
    }
}
