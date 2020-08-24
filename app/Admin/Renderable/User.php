<?php

namespace App\Admin\Renderable;

use App\Models\Role;
use Dcat\Admin\Support\LazyRenderable;
use Dcat\Admin\Widgets\Table;

class User extends LazyRenderable
{
    public function render()
    {
        // 获取ID
        $id = $this->id;

        // 获取其他自定义参数
//        $type = $this->post_type;

        $data = Role::find($id)->users()->orderBy('users.name')
//            ->get(['name','id'])
            ->pluck('txt_name', 'name')
            ->toArray();

//        dump($data);

        $titles = [];

        if (count($data) > 0) {
            $titles = [
                '名稱',
                '登入名',
            ];
        }


//        dump($data);

        return Table::make($titles, $data);
    }
}
