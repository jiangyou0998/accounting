<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalesDataChangeApplicationRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'date' => ['required', 'date', 'before:today'],
        ];
    }

    public function messages()
    {
        return [
            'date.required' => '請選擇「申請時間」',
            'date.before' => '請選擇今天之前的時間',
        ];
    }
}
