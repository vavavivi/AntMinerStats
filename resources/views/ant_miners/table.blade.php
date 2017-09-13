<div class="table-responsive">
    <table class="table table-striped table-valign-middle" id="antMiners-table">
        <thead>
            <th width="1%" class="text-left" colspan="3">Title</th>
            <th width="1%" class="text-center" colspan="1">Updated</th>
            <th width="1%" class="text-center">Errors</th>
            <th width="1%" class="text-center">TH/S</th>
            <th width="1%" class="text-center">Board Temp,°C</th>
            <th width="1%" class="text-center">Board Chips</th>
            <th width="1%" class="text-center">B.Freq</th>
            <th width="1%" class="text-center">Fans, rpm</th>
            <th width="1%" class="text-center"></th>
            <th width="1%" class="text-center">Manage</th>
            <th width="1%" class="text-center">Sort</th>
            <th width="100%" class="text-center"></th>
        </thead>
        <tbody>
        @foreach($antMiners as $location_id => $location_antMiners)
            @foreach($location_antMiners as $antMiner)
            <tr>
                @if($loop->first)
                    <td class="text-center" rowspan="{{$location_antMiners->count() }}" bgcolor="#fff">
                        <i class="fa fa-cubes" aria-hidden="true"></i><br>
                        <small style="padding-right: 5px;">{{\App\Models\Location::find($location_id) ? \App\Models\Location::find($location_id)->title : '  ' }}</small><br>
                    </td>
                @endif

                <!-- TITLE -->
                <td class="small" nowrap>
                    <a class="btn btn-xs btn-{{$data[$antMiner->id]->ok ? 'success' : 'danger'}}" href="{!! route('antMiners.show', [$antMiner->id]) !!}">
                        {!! $antMiner->title !!}
                    </a>
                </td>

                <!-- MANAGE URL -->
                <td class="text-left">
                    <div class='btn-group'>
                        @if($antMiner->url)
                            <a href="{{$antMiner->url}}" class="btn btn-xs btn-default" target="_blank"><i class="glyphicon glyphicon-share"></i></a>
                        @endif
                    </div>
                </td>

            @if($data[$antMiner->id])
                <!-- Update status -->
                <td class="text-center" nowrap>
                    <a class="btn btn-xs btn-{{$data[$antMiner->id]['created_at']->diffInSeconds() > 300 ? 'danger' : 'success'}}">
                        <small>
                        @if($data[$antMiner->id]['created_at']->diffInSeconds() < 60)
                            {{$data[$antMiner->id]['created_at']->diffInSeconds()}}s
                        @elseif($data[$antMiner->id]['created_at']->diffInSeconds() >= 60 && $data[$antMiner->id]['created_at']->diffInSeconds() < 60*60 )
                            {{$data[$antMiner->id]['created_at']->diffInMinutes()}}m
                        @elseif($data[$antMiner->id]['created_at']->diffInSeconds() >= 60*60 && $data[$antMiner->id]['created_at']->diffInSeconds() < 24*60*60 )
                            {{$data[$antMiner->id]['created_at']->diffInHours()}}h
                        @else
                            {{$data[$antMiner->id]['created_at']->diffInDays()}}d
                        @endif
                        ago
                        </small>
                    </a>
                </td>

                <!-- ERRORS -->
                <td class="text-center">
                    <a class='btn btn-{{$data[$antMiner->id]['hw'] < 0.002 ? 'success' : 'warning'}} btn-xs hw-errors'>{!! $data[$antMiner->id]['hw'] !!}%</a>
                </td>

                <!-- HASHRATE -->
                <td class="text-center">
                    <a class='btn btn-{{ $data[$antMiner->id]['hash_rate'] > $antMiner->hr_limit ? 'success' : 'danger'}} btn-xs ths'>{!! number_format(round(intval($data[$antMiner->id]['hash_rate'])/1000,2),2) !!}</a>
                </td>

                <!-- TEMP -->
                <td class="text-left" nowrap="">
                @foreach($data[$antMiner->id]['chains'] as $chain_index => $chain_data)
                    <div class="btn-group">
                        @foreach($chain_data['brd_temp'] as $temperature)
                            <a class='btn btn-{{$temperature < $antMiner->temp_limit ? 'success' : 'warning'}} btn-xs miner-temp'>
                                {{$temperature}}°
                            </a>
                        @endforeach
                    </div>
                @endforeach
                </td>

                <!-- Chips -->
                <td class="text-left" nowrap>
                @foreach($data[$antMiner->id]['chains'] as $chain_index => $chain_data)
                    <div class="btn-group">
                        <a class="btn btn-success btn-xs chip-status">{{$chain_data['chips_condition']['ok']}}</a>
                        <a class="btn btn-{{ $chain_data['chips_condition']['er'] <= 0 ? 'default' : 'danger'}} btn-xs chip-status">{{$chain_data['chips_condition']['er']}}</a>
                    </div>
                @endforeach
                </td>

                <!--Board Freq -->
                <td class="text-center" nowrap>
                @if($data[$antMiner->id])
                    @php
                        $board_freq = 0;
                        foreach($data[$antMiner->id]['chains'] as $chain_index => $chain_data)
                        {
                            $board_freq = $board_freq + $chain_data['brd_freq'];
                        }
                    @endphp
                    <a class="btn btn-default btn-xs freq">
                        {{round($board_freq / count($data[$antMiner->id]['chains']), 0)}} <small>Mhz</small>
                    </a>
                @endif
                </td>

                <!-- Fans -->
                <td class="text-left" nowrap>
                    @foreach($data[$antMiner->id]['fans'] as $fan_id => $fan_speed)
                        <button class="btn btn-default btn-xs fan">{{$fan_speed}} <small>rpm</small></button>
                    @endforeach
                </td>

            @else
                @if($antMiner->active)
                    <td colspan="8" class="text-left">No data to display</td>
                @else
                    <td colspan="8" class="text-left"><small>{{$antMiner->d_reason}}</small></td>
                @endif
            @endif

                <!-- ON/OFF -->
                <td class="text-center">
                    <a href="{!! route('antMiners.state', [$antMiner->id]) !!}" class='btn btn-default btn-xs'><i class="fa fa-toggle-{{$antMiner->active ? 'on' : 'off'}}"></i></a>
                </td>

                <!-- Manage -->
                <td class="text-center">
                    {!! Form::open(['route' => ['antMiners.destroy', $antMiner->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('antMiners.edit', [$antMiner->id]) !!}" class='btn btn-default btn-xs'><i class="fa fa-cogs"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>

                <!-- Sorting -->
                <td class="text-center" nowrap>
                    @if($loop->first)
                        <a class="btn btn-default btn-xs sort" href="{{route('antMiners.desc',$antMiner->id)}}"> <i class="fa fa-angle-down"></i></a>
                        <a class="btn btn-default btn-xs sort" disabled="disabled"> &dash; </a>
                    @elseif($loop->last)
                        <a class="btn btn-default btn-xs sort" disabled="disabled"> &dash; </a>
                        <a class="btn btn-default btn-xs sort" href="{{route('antMiners.asc',$antMiner->id)}}"> <i class="fa fa-angle-up"></i></a>
                    @else
                        <a class="btn btn-default btn-xs sort" href="{{route('antMiners.asc',$antMiner->id)}}"> <i class="fa fa-angle-up"></i></a>
                        <a class="btn btn-default btn-xs sort" href="{{route('antMiners.desc',$antMiner->id)}}"> <i class="fa fa-angle-down"></i></a>
                    @endif
                </td>
                <td></td>
            </tr>
            @endforeach
            @if(! $loop->last)
                <tr>
                    <td colspan="11"></td>
                </tr>
            @endif
        @endforeach
        </tbody>
    </table>
</div>
