<?php

namespace App\Models\Library;


use Dcat\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;

class LibraryGroup extends Model
{
    use ModelTree;

    protected $table = 'library_group';

    public function childMenu() {
        return $this->hasMany('App\Models\Library', 'parent_id', 'id');
    }

    public function allChildrenMenu()
    {
        return $this->childMenu()->with('allChildrenMenu');
    }

}
