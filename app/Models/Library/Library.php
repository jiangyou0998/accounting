<?php

namespace App\Models\Library;


use App\Models\FrontGroup;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Library extends Model
{
    use SoftDeletes;
    protected $table = 'library';

    public function getViewAttribute($value)
    {
        return $value;
    }

    //修改獲取的file_path
//    public function getFilePathAttribute($value)
//    {
//        return $value ? ('/libraries/'.$value) : $value;
//    }

    public function users(): MorphToMany
    {
        return $this->morphToMany(
            User::class,
            'model',
            'front_user_can_views',
            'model_id',
            'user_id'
        );
    }

    public function frontgroups(): MorphToMany
    {
        return $this->morphToMany(
            FrontGroup::class,
            'model',
            'front_group_can_views',
            'model_id',
            'group_id'
        );
    }

    public function scopeCanView($query)
    {
        $id = Auth::id();
        $groupIds = User::with('front_groups')->find($id)->front_groups->pluck('id');

        return $query->where(function ($q) use ($id, $groupIds) {  //閉包返回的條件會包含在括號中
            return $q->whereHas('users', function ($query) use ($id) {
                $query->where('id', $id);
            })
                ->orWhereHas('frontgroups', function ($query) use ($groupIds) {
                    $query->whereIn('id', $groupIds);
                });
        });
    }
}
