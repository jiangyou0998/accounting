<?php

namespace App\Admin\Repositories;

use Dcat\Admin\Repositories\EloquentRepository;
use App\Models\TblOrderCheck as TblOrderCheckModel;

class TblOrderCheck extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = TblOrderCheckModel::class;
}
