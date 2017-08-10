<?php

namespace App\Models;

use App\User;
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
        'user_id',
    	'title',
        'host',
        'type',
        'port',
        'options',
        'log',
        'url'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
	    'user_id' => 'integer',
        'title' => 'string',
        'host' => 'string',
        'port' => 'integer',
        'options' => 'string',
        'log' => 'boolean',
        'url' => 'string',
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
    ];

    public function setOptionsAttribute($array)
    {
    	$this->attributes['options'] = serialize($array);
    }

    public function getOptionsAttribute($value)
    {
    	return unserialize($value);
    }

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function setLogAttribute($value)
    {
        if($value == 0) {
            $this->attributes['log'] = 0;
        }else{
            $this->attributes['log'] = 1;
        }

    }

    
}
