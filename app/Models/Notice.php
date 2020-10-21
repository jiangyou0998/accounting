<?php

namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Notice extends Model
{

    public $timestamps = false;

    public static function getNotices($dept = null)
    {
        $notices = Notice::where('expired_date','>',now());

        if($dept != null){
            $notices = $notices->where('admin_role_id',$dept);
        }

        $notices = $notices
            ->orderByDesc('modify_date')
            ->paginate(10);

        return $notices;
    }

    public static function getDeptName()
    {
        return Notice::where('expired_date','>',now())
            ->leftJoin('admin_roles','admin_roles.id','=','notices.admin_role_id')
            ->distinct()
            ->pluck('admin_roles.name','notices.admin_role_id');
    }

    public static function getNoticesForHome($limit = 6)
    {
        $notices = Notice::where('expired_date','>',now());

        $notices = $notices
            ->orderByDesc('modify_date')
            ->limit($limit)
            ->get();

        return $notices;
    }

//    public static function setAdminRoles()
//    {
//        $depts = DB::table('tbl_dept')->get();
//        dump($depts);
//        $now = Carbon::now()->toDateTimeString();
//        foreach ($depts as $dept){
//            $insertArr = ['name' => $dept->txt_dept , 'slug'=>Str::before($dept->txt_dept,' '),'created_at' => $now , 'updated_at' => $now];
//            DB::table('admin_roles')->insert($insertArr);
////            dump($insertArr);
//        }
//
//
//    }


}
