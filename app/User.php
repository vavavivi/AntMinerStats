<?php

namespace App;

use App\Models\Alert;
use App\Models\AntMiner;
use App\Models\Location;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'chat_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function miners()
    {
    	return $this->hasMany(AntMiner::class);
    }

    public function alerts()
    {
    	return $this->hasMany(Alert::class);
    }

    public function locations()
    {
    	return $this->hasMany(Location::class);
    }

    public function getHashRateAttribute()
    {
    	$miners = $this->miners;

	    $hr = 0;

		foreach($miners as $miner)
		{
			if($miner->antlogs)
			{
				$hr = $hr + $miner->antlogs->sortByDesc('id')->first()->hash_rate;
			}

		}

    	return round($hr/1024, 2);
    }
}
