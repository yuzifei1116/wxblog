<?php

namespace App\Admin\Repositories;

use App\Models\Img as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Img extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
