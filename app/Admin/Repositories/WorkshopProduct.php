<?php

namespace App\Admin\Repositories;

use App\Models\WorkshopProduct as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class WorkshopProduct extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
