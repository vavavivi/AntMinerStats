<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class AntMiner
 * @package App\Models
 * @version July 8, 2017, 1:18 pm UTC
 */
class AntMiner extends Model
{
    public $table = 'ant_miners';

    public $fillable = [
        'title',
        'host',
        'type',
        'port',
        'username',
        'password',
        'options'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'title' => 'string',
        'host' => 'string',
        'port' => 'integer',
        'username' => 'string',
        'password' => 'string',
        'options' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required',
        'host' => 'required',
        'port' => 'required',
        'username' => 'required',
        'password' => 'required'
    ];

    public function setOptionsAttribute($array)
    {
    	$this->attributes['options'] = serialize($array);
    }

    public function getOptionsAttribute($value)
    {
    	return unserialize($value);
    }

    
}