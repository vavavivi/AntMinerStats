<?php

namespace App\Models;

use App\AntMinerLog;
use App\User;
use Eloquent as Model;


class AntMiner extends Model
{
    public $table = 'ant_miners';

    public $fillable = [
    	'active',
    	'd_reason',
    	'order',
        'location_id',
        'user_id',
    	'title',
        'host',
        'type',
        'port',
        'options',
        'log',
        'restart',
	    'temp_limit',
	    'hr_limit',
        'url',
        'f_count',
    ];

    protected $casts = [
	    'active' => 'boolean',
    	'd_reason' => 'string',
    	'order' => 'integer',
	    'location_id' => 'integer',
	    'user_id' => 'integer',
        'title' => 'string',
        'host' => 'string',
        'port' => 'integer',
        'options' => 'string',
        'log' => 'boolean',
        'restart' => 'boolean',
        'url' => 'string',
        'f_count' => 'integer',
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

	public function antlogs()
	{
		return $this->hasMany(AntMinerLog::class);
	}

	public function alerts()
	{
		return $this->hasMany(Alert::class);
	}

	public function location()
	{
		return $this->belongsTo(Location::class);
	}

	public function scopeActive($query)
	{
		return $query->where('active', 1);
	}

	public function getFullTitleAttribute()
	{
		if($this->location)
		{
			return $this->location->title . ' / ' . $this->title;
		}

		return $this->title;
	}

	public function getFullTitleUrlAttribute($target = null)
	{
		$url = route('antMiners.show',$this->id);

		return '<a href="'.$url.'">'.$this->full_title.'</a>';

	}



}
