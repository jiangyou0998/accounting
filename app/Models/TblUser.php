<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class TblUser extends Model
{

    protected $table = 'tbl_user';

    protected $primaryKey = 'int_id';

    public $timestamps = false;

    public function cartitems()
    {
        return $this->hasMany(TblOrderZDept::class,'int_id','int_user');
    }

    public static function getKingBakeryShops(){

        $users = new TblUser();
        $shops = $users->where('chr_type', 2)
            ->where('txt_login','like','kb%')
            ->orWhere('txt_login','like','ces%')
            ->orWhere('txt_login','like','b&b%')
            ->orderBy('txt_login')
            ->get(['int_id','chr_report_name']);

        return $shops;
    }

    public static function getTestUserIDs(){

        $testUserIDs = [1,2,3,4,77,82];

        return $testUserIDs;
    }


}
