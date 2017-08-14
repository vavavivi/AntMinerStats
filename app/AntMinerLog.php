<?php

namespace App;

use App\Models\AntMiner;
use Illuminate\Database\Eloquent\Model;

class AntMinerLog extends Model
{
	public $table = 'ant_miner_logs';

	public $fillable = [
		'ant_miner_id',
		'temp1',
		'temp11',
		'temp2',
		'temp21',
		'temp3',
		'temp31',
		'freq1',
		'freq2',
		'freq3',
		'hr',
		'created_at',
	];

	protected $casts = [
		'ant_miner_id' => 'integer',
		'temp1' => 'integer',
		'temp11' => 'integer',
		'temp2' => 'integer',
		'temp21' => 'integer',
		'temp3' => 'integer',
		'temp31' => 'integer',
		'freq1' => 'integer',
		'freq2' => 'integer',
		'freq3' => 'integer',
		'hr' => 'integer',
	];

	public function antMiner()
	{
		return $this->belongsTo(AntMiner::class);
	}
}
