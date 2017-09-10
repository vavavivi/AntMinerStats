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
		return true;
	}
}
