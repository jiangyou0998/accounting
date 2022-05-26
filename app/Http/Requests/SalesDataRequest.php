<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalesDataRequest extends FormRequest
{

    public function rules()
    {
        return [
            'inputs.0.*' => ['nullable', 'numeric', 'min:0'],
            'first_pos_no' => ['nullable', 'numeric', 'min:0'],
        ];
    }

    public function messages()
    {
        return [

            'inputs.0.*.numeric' => '「:attribute」請輸入正確的數字',
            'inputs.0.*.min' => '「:attribute」請輸入大於零的數字',
//            'first_pos_no.required' => '請輸入主機No.',
            'first_pos_no.numeric' => '主機No.請輸入數字',
            'first_pos_no.min' => '主機No.請輸入大於零的數字',
        ];
    }

    public function attributes()
    {
        return [
            'inputs.0.first_pos_income' => '主機收入',
            'inputs.0.second_pos_income' => '副機收入',

            'inputs.0.morning_income' => '早更收入',
            'inputs.0.afternoon_income' => '午更收入',
            'inputs.0.evening_income' => '晚更收入',

            'inputs.0.octopus_income' => '八達通',
            'inputs.0.alipay_income' => '支付寶',
            'inputs.0.wechatpay_income' => '微信',
            'inputs.0.coupon_income' => '現金券',
            'inputs.0.credit_card_income' => '信用卡',

            'inputs.0.pos_money_1000' => '$1000紙幣',
            'inputs.0.pos_money_500' => '$500紙幣',
            'inputs.0.pos_money_100' => '$100紙幣',
            'inputs.0.pos_money_50' => '$50紙幣',
            'inputs.0.pos_money_20' => '$20紙幣',
            'inputs.0.pos_money_10' => '$00紙幣',
            'inputs.0.pos_coin' => '輔幣總額',

            'inputs.0.deposit_in_bank' => '存入銀行',

        ];
    }
}
