<?php

namespace App\Repositories;

use App\Models\Faq;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class FaqRepository
 * @package App\Repositories
 * @version September 20, 2017, 10:13 am EEST
 *
 * @method Faq findWithoutFail($id, $columns = ['*'])
 * @method Faq find($id, $columns = ['*'])
 * @method Faq first($columns = ['*'])
*/
class FaqRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'text',
        'order'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Faq::class;
    }
}
