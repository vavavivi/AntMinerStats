<?php

namespace App\Models;

use App\User;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Alert
 * @package App\Models
 * @version August 27, 2017, 10:01 pm EEST
 *
 * @property integer miner_id
 */
class Alert extends Model
{

    public $table = 'alerts';
    


    public $fillable = [
        'user_id',
        'ant_miner_id',
	    'subject',
	    'body',
        'status',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'ant_miner_id' => 'integer',
        'status' => 'string',
        'subject' => 'string',
        'body' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'required',
        'ant_miner_id' => 'required',
        'subject' => 'required',
        'body' => 'required',
    ];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function antMiner()
    {
    	return $this->belongsTo(AntMiner::class);
    }

    
}
