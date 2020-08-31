<?php

namespace App\Models;

use Dcat\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;


/**
 * Class Menu.
 *
 * @property int $id
 *
 * @method where($parent_id, $id)
 */
class Menu extends Model
{
    use ModelTree;

    protected $table = 'menu';

    public function childMenu() {
        return $this->hasMany('App\Models\Menu', 'parent_id', 'id');
    }

    public function allChildrenMenu()
    {
        return $this->childMenu()->with('allChildrenMenu');
    }

}
