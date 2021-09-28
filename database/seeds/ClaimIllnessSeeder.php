<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClaimIllnessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $claimIllnessArr = [
            '其他',
            '胃腸炎',
            '腹瀉',
            '結膜炎',
            '霰粒腫 (眼部)',
            '耳垢',
            '普通感冒',
            '咽喉炎',
            '扁桃腺炎',
            '喉炎',
            '感染病毒',
            '鼻炎',
            '鼻竇炎',
            '流行性感冒',
            '支氣管炎',
            '上呼吸道感染',
            '牙齦炎',
            '便秘',
            '包皮炎',
            '濕疹/皮炎',
            '皮膚炎',
            '頭暈',
            '頭痛',
            '喉嚨痛',
            '流鼻血',
            '咳嗽',
            '嘔吐',
            '肚痛',
            '受傷',
            '皮膚敏感',
            '外來物'
        ];

        $sort = 100;
        foreach ($claimIllnessArr as $value){
            DB::table('selector_items')->insert([
                'type_name' => 'claim_illness',
                'sort' => $sort,
                'item_name' => $value,
            ]);
            $sort += 100;
        }


    }
}
