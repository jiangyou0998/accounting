<?php

namespace App\Models;


use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Notice extends Model
{
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

    public function attachments()
    {
        return $this->hasMany(NoticeAttachment::class,"notice_id","id");
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
            ->orderByDesc('updated_at')
            ->orderByDesc('id')
            ->paginate(10);

        foreach ($notices as &$notice){
            $notice->isNew = false;
            $modify_date = Carbon::parse($notice->updated_at);
            $now = Carbon::now();

            //七日內是新
            if($now->diffInDays($modify_date,false) > -7){
                $notice->isNew = true;
            }
        }

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
            ->orderByDesc('updated_at')
            ->orderByDesc('id')
            ->limit($limit)
            ->get();

        return $notices;
    }

    public static function getNoticesAttachment($id)
    {
        $notices = Notice::with('attachments')->find($id);
        return $notices;
    }

    // 定义一个public方法访问图片或文件
    public function getFile()
    {
        //有附件
        if ($this->is_directory){
            $files = array();
            foreach ($this->attachments as $attachment){
                $file_path = Storage::disk('notice')->url($attachment->file_path);
                $files[$file_path] = $attachment->title;
            }
            return $files;
        }

        //無附件
        if (Str::contains($this->file_path, '//')) {
            return $this->file_path;
        }

        return Storage::disk('notice')->url($this->file_path);
    }

}
