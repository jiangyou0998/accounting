<?php

namespace App\Admin\Repositories;

use App\Models\WorkshopProduct as Model;
use Dcat\Admin\Contracts\Repository;
use Dcat\Admin\Contracts\TreeRepository;
use Dcat\Admin\Repositories\EloquentRepository;
use Dcat\Admin\Support\Helper;

class WorkshopProduct extends EloquentRepository implements Repository, TreeRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;

    protected $queryCallbacks = [];

    public function withQuery($queryCallback)
    {
        $this->queryCallbacks[] = $queryCallback;

        return $this;
    }

    public function toTree()
    {
        // 这里演示的代码只是为了说明 withQuery 方法的作用
        $client = (new \App\Models\WorkshopGroup())->with('products');


        foreach ($this->queryCallbacks as $callback) {
            $callback($client);
        }
//        dump($client->get()->toArray());
        return $client->get()->toArray();
    }

}
