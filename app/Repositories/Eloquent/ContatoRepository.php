<?php

namespace App\Repositories\Eloquent;

use App\Models\Contato;
use App\Repositories\Eloquent\BaseRepository;

class ContatoRepository extends BaseRepository
{
    /**
     * @var Contato
     */
    protected $model;

    public function __construct(Contato $model)
    {
        $this->model = $model;
    }
}