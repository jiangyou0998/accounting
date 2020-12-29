<?php

namespace App\Models;


use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Notice extends Model
{

    public $timestamps = false;

    protected $guarded = [];

    public function roles()
    {
        $roleModel = config('admin.database.roles_model');

        return $this->belongsTo($roleModel,"admin_role_id","id");
    }

    public function users()
    {
        $userModel = config('admin.database.users_model');

        return $this->belongsTo($userModel,"user_id","id");
    }

    public function frontusers()
    {
        $userModel = new User();

        return $this->belongsTo($userModel,"user_id","id");
    }

    public static function getNotices($dept = null ,$search = null)
    {
        $notices = Notice::where('expired_date','>',now());

        if($dept != null){
            $notices = $notices->where('admin_role_id',$dept);
        }

        if($search != null){
            $notices = $notices
                ->where('notice_name','like',"%".$search."%")
                ->orWhere('notice_no','like',"%".$search."%");
        }

        $notices = $notices
            ->orderByDesc('modify_date')
            ->orderByDesc('id')
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
            ->orderByDesc('id')
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
