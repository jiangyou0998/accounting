<?php

namespace App\Models\Library;


use App\Models\FrontGroup;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Library extends Model
{
    use SoftDeletes;
    protected $table = 'library';

    public function getViewAttribute($value)
    {
        return $value;
    }

    //修改獲取的file_path
    public function getFilePathAttribute($value)
    {
        return $value ? ('/libraries/'.$value) : $value;
    }

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

}
