<?php

namespace App\Models;

use App\User;
use Eloquent as Model;

class Location extends Model
{

    public $table = 'locations';
    
    public $fillable = [
        'user_id',
        'title'
    ];

    protected $casts = [
        'user_id' => 'integer',
        'title' => 'string'
    ];

    public static $rules = [
        'title' => 'required'
    ];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function miners()
    {
    	return $this->hasMany(AntMiner::class);
    }

}
