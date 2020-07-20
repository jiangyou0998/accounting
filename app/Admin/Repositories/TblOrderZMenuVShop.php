<?php

namespace App\Admin\Repositories;

use Dcat\Admin\Repositories\EloquentRepository;
use App\Models\TblOrderZMenuVShop as TblOrderZMenuVShopModel;

class TblOrderZMenuVShop extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = TblOrderZMenuVShopModel::class;
}
