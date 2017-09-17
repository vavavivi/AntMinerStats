<div class="table-responsive">
    <table class="table table-striped table-valign-middle" id="antMiners-table">
        <thead>
            <th class="text-center" colspan="2">Title</th>
            <th class="text-center">Status</th>
            <th class="text-center">Errors</th>
            <th class="text-center">TH/S</th>
            <th class="text-center">Board Temp,°C</th>
            <th class="text-center">Board Chips</th>
            <th class="text-center">B.Freq</th>
            <th class="text-center">Fans, rpm</th>
            <th class="text-center"></th>
            <th class="text-center">Manage</th>
            <th class="text-center">Sort</th>
            <th width="100%"></th>
        </thead>
        <tbody>
        @foreach($antMiners as $location_id => $location_antMiners)
            @foreach($location_antMiners->sortBy('order') as $antMiner)

            @if($loop->first)
                <tr>
                    <td class="text-left" colspan="14" style="border-top: 1px solid #ccc; border-bottom: 1px solid #ccc;">
                        <i class="fa fa-cubes" aria-hidden="true"></i>
                        <strong style="padding-right: 5px;">{{\App\Models\Location::find($location_id) ? \App\Models\Location::find($location_id)->title : '  ' }}</strong>
                        | <small>Count: {{$location_antMiners->count()}}</small>
                    </td>
                </tr>
            @endif

            <tr>

                <!-- TITLE -->
                <td class="small" nowrap>
                    <a href="{!! route('antMiners.show', [$antMiner->id]) !!}"><i class="fa fa-angle-right"></i> {!! $antMiner->title !!}</a>
                </td>


                <!-- MANAGE URL -->
                <td class="text-left">
                    @if($antMiner->url)
                        <a href="{{$antMiner->url}}"  class="btn btn-xs btn-default" target="_blank"><i class="glyphicon glyphicon-share"></i></a>
                    @endif
                </td>


            @if($data[$antMiner->id])
                <!-- Check status -->
                <td class="text-center" nowrap>
                    <a class="btn btn-xs btn-default">
                        <span><i class="fa {{$data[$antMiner->id]->ok ? 'fa-check-circle color-green' : 'fa-exclamation-circle color-red'}}"></i></span> |
                        <i class="fa fa-clock-o color-{{$data[$antMiner->id]['created_at']->diffInSeconds() > 300 ? 'red' : 'green'}}"></i>
                        @if($data[$antMiner->id]['created_at']->diffInSeconds() < 60)
                            {{$data[$antMiner->id]['created_at']->diffInSeconds()}}s
                        @elseif($data[$antMiner->id]['created_at']->diffInSeconds() >= 60 && $data[$antMiner->id]['created_at']->diffInSeconds() < 60*60 )
                            {{$data[$antMiner->id]['created_at']->diffInMinutes()}}m
                        @elseif($data[$antMiner->id]['created_at']->diffInSeconds() >= 60*60 && $data[$antMiner->id]['created_at']->diffInSeconds() < 24*60*60 )
                            {{$data[$antMiner->id]['created_at']->diffInHours()}}h
                        @else
                            {{$data[$antMiner->id]['created_at']->diffInDays()}}d
                        @endif
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
                    <td colspan="7" class="text-left">No data to display</td>
                @else
                    <td colspan="7" class="text-left"><small>{!! $antMiner->d_reason !!}</small></td>
                @endif
            @endif

                <!-- ON/OFF -->
                <td class="text-center">
                    <a href="{!! route('antMiners.state', [$antMiner->id]) !!}" class='btn btn-default btn-xs'><i class="fa fa-toggle-{{$antMiner->active ? 'on' : 'off'}}"></i></a>
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

                <!-- Manage -->
                <td class="text-center">
                    {!! Form::open(['route' => ['antMiners.destroy', $antMiner->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('antMiners.edit', [$antMiner->id]) !!}" class='btn btn-default btn-xs'><i class="fa fa-cogs"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>


                <td></td>
            </tr>
            @endforeach
        @endforeach
        </tbody>
    </table>
</div>
