<?php

namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ClaimLevel extends Model
{

    protected $table = 'claim_levels';
    public $timestamps = false;

    //索償等級詳情
    public function details()
    {
        return $this->hasMany(ClaimLevelDetail::class,"claim_level_id","id");
    }

    public static function getPlanNoArray(){
        return self::distinct()
            ->orderBy('plan_no')
            ->pluck('plan_no','plan_no')
            ->toArray();
    }

    public static function getClaimLevels(int $plan_no = 0){

        if($plan_no === 0){
            $claim_levels = self::all();
        }else{
            $claim_levels = self::where('plan_no', $plan_no)->get();
        }

        foreach ($claim_levels as $claim_level){
            $claim_level->plan_name = 'Plan'. $claim_level->plan_no . '-' .$claim_level->type_name;
        }

        return $claim_levels->pluck('plan_name','id');
    }

    public static function getClaimLevelsGroupByPlanNo(){

        $claim_levels = self::all();

        foreach ($claim_levels as $claim_level){
            $claim_level->plan_name = 'Plan'. $claim_level->plan_no . '-' .$claim_level->type_name;
        }

//        dd($claim_levels->toArray());

        $grouped = $claim_levels->mapToGroups(function ($item, $key) use($claim_levels){
            return [
                $item['plan_no'] => [ $item['id'] => $item['plan_name'] ]
            ];
        });

//        dump($grouped->toArray());

        return $grouped;
        return $claim_levels->pluck('plan_name','id');
    }

}
