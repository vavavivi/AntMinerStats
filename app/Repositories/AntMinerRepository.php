<?php

namespace App\Repositories;

use App\Models\AntMiner;
use InfyOm\Generator\Common\BaseRepository;

class AntMinerRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'host',
        'port',
        'username',
        'password',
        'options'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return AntMiner::class;
    }
}
