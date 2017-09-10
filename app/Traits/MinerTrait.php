<?php

namespace App\Traits;


use App\Models\AntMiner;

trait MinerTrait
{
    public function read_from_socket(AntMiner $antMiner, $command)
    {
        $host = $antMiner->host;
        $port = $antMiner->port;

        $connection = null;

        try{
            ini_set("default_socket_timeout", 5);
            $connection = fsockopen($host, $port,$errstr);

        }
        catch(\Exception $e){

        }

        if (!$connection) {
            return false;
        }

        fwrite($connection, $command);
        $reply = stream_get_contents($connection);

        stream_socket_shutdown($connection, STREAM_SHUT_WR);
        fclose($connection);
        $connection = null;


        return $reply;
    }

    public function get_api_data(AntMiner $antMiner)
    {
        $reply['stats'] = $this->get_api_stats($antMiner);
        $reply['pools'] = $this->get_api_pools($antMiner);
        $reply['summary'] = $this->get_api_summary($antMiner);

        return $reply;
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

    public function parseStats($array)
    {
        $reply = explode('|',$array);
        $result = [];

        foreach($reply as $block=>$data_raw)
        {
            $data = explode(',',$data_raw);

            foreach($data as $id=>$value)
            {
                if(substr( $value, 0, 11 ) === "chain_xtime" OR substr( $value, 0, 1 ) === "X")
                {
                }
                else
                {
                    $temp = explode('=',$value);
                }

                if(key_exists(0,$temp) && key_exists(1,$temp))
                {
                    $result[$temp[0]] = $temp[1];
                }
            }
        }

        return $result;
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

        $miner_stats = $this->parseStats($this->get_api_stats($antMiner));

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

}