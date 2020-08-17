<?php

namespace App\Admin\Repositories;

use App\Models\Permission as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Permission extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
