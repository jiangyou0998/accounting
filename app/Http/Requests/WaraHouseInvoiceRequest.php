<?php

namespace App\Http\Requests;

use App\Models\Repairs\RepairProject;
use Illuminate\Foundation\Http\FormRequest;

class WaraHouseInvoiceRequest extends FormRequest
{
    public function rules()
    {
        return [
            'date' => 'required|before:tomorrow',
            'invoice_no' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'date.before' => '訂單日期必須為明天之前的日期！',
        ];
    }
}
