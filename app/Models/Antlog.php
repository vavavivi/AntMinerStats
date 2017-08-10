<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Antlog extends Model
{
    public $table = 'antlogs';

    public $fillable = [
        'ant_miner_id',
        'data',
    ];

    protected $casts = [
        'ant_miner_id' => 'integer',
        'data' => 'array',
    ];

    public function antMiner()
    {
        return $this->belongsTo(AntMiner::class);
    }
}
