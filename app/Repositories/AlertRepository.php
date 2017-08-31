<?php

namespace App\Repositories;

use App\Models\Alert;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class AlertRepository
 * @package App\Repositories
 * @version August 27, 2017, 10:01 pm EEST
 *
 * @method Alert findWithoutFail($id, $columns = ['*'])
 * @method Alert find($id, $columns = ['*'])
 * @method Alert first($columns = ['*'])
*/
class AlertRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'miner_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Alert::class;
    }
}
