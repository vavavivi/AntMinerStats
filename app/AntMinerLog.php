<?php

namespace App;

use App\Models\AntMiner;
use Illuminate\Database\Eloquent\Model;

class AntMinerLog extends Model
{
	public $table = 'ant_miner_logs';

	public $fillable = [
		'ant_miner_id',
		'hash_rate',
		'hw',
		'fans',
		'chains',
	];

	protected $casts = [
		'ant_miner_id' => 'integer',
		'hash_rate' => 'integer',
		'hw' => 'double',
		'fans' => 'array',
		'chains' => 'array',
	];

	public function antMiner()
	{
		return $this->belongsTo(AntMiner::class);
	}

	public function getOkAttribute()
	{
		$hr_limit = $this->antMiner->hr_limit;
		$temp_limit = $this->antMiner->temp_limit;


		if($this->hash_rate < $hr_limit)
		{
			return false;
		}

		if($this->hw > 0.01)
		{
			return false;
		}

		foreach($this->chains as $chain)
		{
			if($chain['chips_condition']['er'] > 0)
			{
				return false;
			}

			foreach($chain['brd_temp'] as $temperature)
			{
				if($temperature > $temp_limit)
				{
					return false;
				}
			}

		}

		return true;
	}
}
