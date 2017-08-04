<table class="table table-valign-middle" id="antMiners-table">
    <thead>
        <th width="5%">Title</th>
        <th width="1%" class="text-center">TH/S</th>
        <th width="15%" class="text-left">Board Temp,°C</th>
        <th width="15%">Chips Status</th>
        <th width="15%" class="text-left">Board Freq</th>
        <th width="15%" class="text-left">FANs</th>
        <th width="20%" class="text-center">Action</th>
    </thead>
    <tbody>
    @foreach($antMiners as $antMiner)
        <tr>
            <td class="small" nowrap>{!! $antMiner->title !!}</td>

            <td class="text-center">
                <button class="btn btn-default btn-xs"><strong>{!! round(intval($data[$antMiner->id]['hash_rate'])/1000,2) !!}</strong></button>
            </td>

            @if($data[$antMiner->id])
                <td class="text-left small" nowrap="">
                    @foreach($data[$antMiner->id]['chains'] as $chain_index => $chain_data)
                        @if($antMiner->type == 'bmminer')
                        <div class="btn-group">
                            @if(intval($chain_data['brd_temp1']) > 90)
                                <button class="btn btn-danger btn-xs miner-temp"> {{$chain_data['brd_temp1']}} °C</button>
                            @elseif(intval($chain_data['brd_temp1']) > 80)
                                <button class="btn btn-warning btn-xs miner-temp"> {{$chain_data['brd_temp1']}} °C</button>
                            @else
                                <button class="btn btn-success btn-xs miner-temp"> {{$chain_data['brd_temp1']}} °C</button>
                            @endif

                            @if(intval($chain_data['brd_temp2']) > 90)
                                <button class="btn btn-danger btn-xs miner-temp"> {{$chain_data['brd_temp2']}} °C</button>
                            @elseif(intval($chain_data['brd_temp2']) > 80)
                                <button class="btn btn-warning btn-xs miner-temp"> {{$chain_data['brd_temp2']}} °C</button>
                            @else
                                <button class="btn btn-success btn-xs miner-temp"> {{$chain_data['brd_temp2']}} °C</button>
                            @endif
                        </div>
                        @else
                            @if(intval($chain_data['brd_temp']) > 79)
                                <button class="btn btn-danger btn-xs miner-temp"> {{$chain_data['brd_temp']}} °C</button>
                            @elseif(intval($chain_data['brd_temp']) > 69)
                                <button class="btn btn-warning btn-xs miner-temp"> {{$chain_data['brd_temp']}} °C</button>
                            @else
                                <button class="btn btn-success btn-xs miner-temp"> {{$chain_data['brd_temp']}} °C</button>
                            @endif
                        @endif
                    @endforeach
                </td>
                <td nowrap>
                    @foreach($data[$antMiner->id]['chains'] as $chain_index => $chain_data)
                    <div class="btn-group">
                            @if(intval($chain_data['chips_condition']['ok'])>0)
                                <button class="btn btn-success btn-xs chip-status">{{$chain_data['chips_condition']['ok']}}</button>
                            @else
                                <button class="btn btn-danger btn-xs chip-status">&mdash;</button>
                            @endif
                        <button class="btn @if(intval($chain_data['chips_condition']['er']) > 0) btn-danger @else btn-default @endif btn-xs chip-status">{{$chain_data['chips_condition']['er']}}</button>
                    </div>
                    @endforeach
                </td>

                <!--Board Freq -->
                <td class="text-left" nowrap>
                    @foreach($data[$antMiner->id]['chains'] as $chain_index => $chain_data)
                        @if(round(intval($chain_data['brd_freq'])) > 749)
                            <button class="btn btn-warning btn-xs freq">B{{$chain_index}}: {{round(intval($chain_data['brd_freq']),0)}} Mhz</button>
                        @elseif(round(intval($chain_data['brd_freq'])) == 0)
                                <button class="btn btn-danger btn-xs freq">B{{$chain_index}}: {{round(intval($chain_data['brd_freq']),0)}} Mhz</button>
                        @else
                            <button class="btn btn-default btn-xs freq">B{{$chain_index}}: {{round(intval($chain_data['brd_freq']),0)}} Mhz</button>
                        @endif

                    @endforeach
                </td>

                <!-- FANS -->
                <td class="text-left" nowrap>
                    @foreach($data[$antMiner->id]['fans'] as $fan_id => $fan_speed)
                        <button class="btn btn-default btn-xs">{{title_case($fan_id)}}: {{$fan_speed}}</button>
                    @endforeach
                </td>
            @else
                <td colspan="4">ERROR: Cannot fetch data</td>
            @endif

            <td class="text-center">
                {!! Form::open(['route' => ['antMiners.destroy', $antMiner->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('antMiners.show', [$antMiner->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('antMiners.edit', [$antMiner->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
