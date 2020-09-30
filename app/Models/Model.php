<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

abstract class Model extends EloquentModel
{
    /**
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = 10;
}