<?php

namespace App\Admin\Repositories;

use Dcat\Admin\Repositories\EloquentRepository;
use App\Models\TblOrderZCat as TblOrderZCatModel;

class TblOrderZCat extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = TblOrderZCatModel::class;
}
