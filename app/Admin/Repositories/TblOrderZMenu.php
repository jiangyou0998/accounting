<?php

namespace App\Admin\Repositories;

use Dcat\Admin\Repositories\EloquentRepository;
use App\Models\TblOrderZMenu as TblOrderZMenuModel;

class TblOrderZMenu extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = TblOrderZMenuModel::class;
}
