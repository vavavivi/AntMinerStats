<?php

namespace App\Models;

use App\AntMinerLog;
use App\User;
use Eloquent as Model;


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
	    'temp_limit',
	    'hr_limit',
        'url'
    ];

    protected $casts = [
	    'user_id' => 'integer',
        'title' => 'string',
        'host' => 'string',
        'port' => 'integer',
        'options' => 'string',
        'log' => 'boolean',
        'url' => 'string',
    ];

    public static $rules = [
        'title' => 'required',
        'host' => 'required',
        'port' => 'required',
	    'temp_limit' => 'integer|nullable',
	    'hr_limit' => 'integer|nullable',
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

    public function antMinerlogs()
    {
        return $this->hasMany(Antlog::class);
    }

	public function antlogs()
	{
		return $this->hasMany(AntMinerLog::class);
	}

}
