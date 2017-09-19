<?php

namespace App\Traits;

use App\Jobs\SendAlert;
use App\Models\AntMiner;
use Carbon\Carbon;

trait MinerTrait
{
    public function read_from_socket(AntMiner $antMiner, $command)
    {
        $host = $antMiner->host;
        $port = $antMiner->port;

        $connection = null;

        try{
            $connection = fsockopen($host, $port, $errno, $errstr, 5);

        }
        catch(\Exception $e){
			//dd($e);
        }

        if (!$connection) {
            return false;
        }

        fwrite($connection, $command);
        $reply = stream_get_contents($connection);

        stream_socket_shutdown($connection, STREAM_SHUT_WR);
        fclose($connection);
        $connection = null;

        return str_replace("\0", '', $reply);
    }

    public function get_api_stats(AntMiner $antMiner)
    {
        return $this->read_from_socket($antMiner, 'stats');
    }

    public function get_api_pools(AntMiner $antMiner)
    {
        return $this->read_from_socket($antMiner, 'pools');
    }

    public function get_api_summary(AntMiner $antMiner)
    {
        return $this->read_from_socket($antMiner, 'summary');
    }

    public function parseStats($string)
    {
	    $string = preg_replace('/{[\s\S]+?}/', '', $string);

        $parse = explode('|',$string);

	    $reply = array_filter($parse);
	    $data = [];

	    foreach($reply as $data_raw)
	    {
		    foreach(explode(',',$data_raw) as $item)
		    {
			    $temp = explode('=',$item);
			    $data[$temp[0]] = count($temp) > 1 ? $temp[1] : null;
		    }
	    }

        return $data;
    }

    public function parsePools($array)
    {
        $reply = explode('|',$array);
        $result = [];

        foreach($reply as $block=>$data_raw)
        {
            if(substr( $data_raw, 0, 6 ) === "STATUS")
            {

            }

            else
            {
                $data = explode(',',$data_raw);
                foreach($data as $id=>$value)
                {
                    $temp = explode('=',$value);


                    if(key_exists(0,$temp) && key_exists(1,$temp))
                    {
                        $result[$block][$temp[0]] = $temp[1];
                    }
                }
            }
        }

        return $result;
    }

    public function formatMinerData(AntMiner $antMiner)
    {
        $chip_ok_count = 0;
        $chip_er_count = 0;

        $miner_data = $this->get_api_stats($antMiner);

        if(!$miner_data)
        {
            return false;
        }

        $miner_stats = $this->parseStats($miner_data);

        $stats = null;

	    $stats['hash_rate'] = round($miner_stats['GHS 5s']);

        $stats['hw'] = floatval($miner_stats['Device Hardware%']);

        foreach($antMiner->options as $option_key => $option_value)
        {
            if(substr( $option_key, 0, 3 ) === "fan")
            {
                $stats['fans'][$option_key] = round($miner_stats[$option_key]);
            }

            if(substr( $option_key, 0, 9 ) === "chain_acn")
            {
                $chain_index = substr( $option_key, -1, 1 );

                $brd_chips_var = 'chain_acn'.$chain_index;
                $brd_chips_stat_var = 'chain_acs'.$chain_index;


                $stats['chains'][$chain_index]['chips'] = round($miner_stats[$brd_chips_var]);
                $stats['chains'][$chain_index]['chips_stat'] = str_split(str_replace(' ', '', $miner_stats[$brd_chips_stat_var]));

                foreach($stats['chains'][$chain_index]['chips_stat'] as $chip)
                {
                    if($chip == 'o')
                    {
                        $chip_ok_count++;
                    }
                    else
                    {
                        $chip_er_count++;
                    }
                }

                $stats['chains'][$chain_index]['chips_condition']['ok'] = $chip_ok_count;
                $stats['chains'][$chain_index]['chips_condition']['er'] = $chip_er_count;

                $chip_ok_count = 0;
                $chip_er_count = 0;



                if($antMiner->type == 'bmminer')
                {
                    $brd1_temp_var = 'temp2_'.$chain_index;
                    $brd2_temp_var = 'temp3_'.$chain_index;

                    $brd_freq_var = 'freq_avg'.$chain_index;

                    if(! array_key_exists($brd1_temp_var, $miner_stats)) $miner_stats[$brd1_temp_var] = 0;
                    if(! array_key_exists($brd2_temp_var, $miner_stats)) $miner_stats[$brd2_temp_var] = 0;
                    if(! array_key_exists($brd_freq_var, $miner_stats))  $miner_stats[$brd_freq_var] = 0;

                    $stats['chains'][$chain_index]['brd_temp'][] = round($miner_stats[$brd1_temp_var]);
                    $stats['chains'][$chain_index]['brd_temp'][] = round($miner_stats[$brd2_temp_var]);
                    $stats['chains'][$chain_index]['brd_freq']  = round($miner_stats[$brd_freq_var]);
                }
                else
                {
                    $brd_temp_var = 'temp'.$chain_index;

	                if(! array_key_exists($brd_temp_var, $miner_stats)) $miner_stats[$brd_temp_var] = 0;

                    $stats['chains'][$chain_index]['brd_temp'][] = round($miner_stats[$brd_temp_var]);
                    $stats['chains'][$chain_index]['brd_freq']  = round($miner_stats['frequency']);
                }


            }
        }

        return $stats;
    }

    public function storeLog($miner_data, AntMiner $antMiner )
    {
	    $antMinerLog = null;

    	if(! $miner_data)
	    {
		    return null;
	    }

	    $this->clearLogs($antMiner);
	    $antMinerLog = $antMiner->antlogs()->create($miner_data);

    	return $antMinerLog;
    }

	public function clearLogs(AntMiner $antMiner)
    {
    	$logs_count = 0;
	    if( $antMiner->antlogs->count() > 1440 )
	    {
		    foreach($antMiner->antlogs->sortBy('id')->take($antMiner->antlogs->count() - 1440) as $log)
		    {
			    $log->delete();
			    $logs_count++;
		    }
	    }

	    return $logs_count;
    }

    public function analizeLog($antMinerLog, AntMiner $antMiner)
    {
	    $msg_array = [];
	    $url = route('antMiners.show',$antMiner->id);

	    if(! $antMinerLog)
	    {
		    $antMiner->increment('f_count');

		    $msg_array[] = "⚠️ <a href='". $url ."'>Anminer: ". $antMiner->title . "</a> is offline or unable to connect.\n Please check your internet connection.\n Try #" .$antMiner->f_count;

		    if( $antMiner->f_count >= 5 )
		    {
			    $disable_reason = "⛔️ <a href='". $url ."'>Anminer: ". $antMiner->title . "</a> was disabled after 5 attempts to connect to ASIC on: " .Carbon::now()->format('d.m.Y H:i:s');

			    $msg_array[] = $disable_reason;

			    $antMiner->update([
				    'active'   => false,
				    'd_reason' => $disable_reason,
				    'f_count'  => 0,
			    ]);
		    }
	    }
	    else
	    {
		    if( $antMiner->hr_limit && $antMinerLog['hash_rate'] < $antMiner->hr_limit )
		    {
			    $msg_array[] = "⚡️ <a href='". $url ."'>Anminer: ". $antMiner->title . "</a> low Hashrate alert: <b>". round($antMinerLog['hash_rate'] / 1024, 2) ." Th</b>.\n Your limit is: <b>". round($antMiner->hr_limit / 1024, 2) ." Th</b>.";

			    if( $antMinerLog['hash_rate'] < 500 && $antMiner->restart )
			    {
				    $restart = $this->read_from_socket($antMiner, 'restart');
				    $msg_array[] = 'Restart ' . $antMiner->title . ' due to <b>0 hashrate</b>.Result: ' . $restart;
			    }
		    }

		    if( $antMiner->temp_limit )
		    {
			    $max_temp = 0;
			    foreach($antMinerLog['chains'] as $chain)
			    {
				    foreach($chain['brd_temp'] as $cur_temp)
				    {
					    if( $cur_temp > $max_temp )
					    {
						    $max_temp = $cur_temp;
					    }
				    }
			    }

			    if( $max_temp > $antMiner->temp_limit )
			    {
				    $msg_array[] = "☀️ <a href='". $url ."'>Anminer: ". $antMiner->title . "</a> high temperature alert: <b>". $max_temp ." °C</b>.\n Your limit is: <b>". $antMiner->temp_limit ." °C</b>.";
			    }
		    }

		    $data = null;

		    $antMiner->update(['f_count' => 0]);
	    }

	    foreach($msg_array as $message)
	    {
		    SendAlert::dispatch($antMiner, $message);
	    }
    }

}