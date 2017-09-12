<div class="table-responsive">
    <table class="table table-hover table-valign-middle" id="antMiners-table">
        <thead>
            <th width="1%" class="text-left" colspan="2">Miner title</th>
            <th width="1%" class="text-left" colspan="2">Status</th>
            <th width="1%" class="text-center">Errors</th>
            <th width="1%" class="text-center">TH/S</th>
            <th width="1%" class="text-left">Board Temp,°C</th>
            <th width="1%" class="text-left">Board Chips</th>
            <th width="1%" class="text-left">Board Freq</th>
            <th width="1%" class="text-left">Fans, rpm</th>
            <th width="1%" class="text-left">Updated</th>
            <th width="1%" class="text-center"></th>
            <th width="1%" class="text-center">Manage</th>
            <th width="1%" class="text-center">Sort</th>
            <th width="100%" class="text-center"></th>
        </thead>
        <tbody>
        @foreach($antMiners->sortBy('order') as $antMiner)
            <tr>

                <!-- TITLE -->
                <td class="small" nowrap>
                    <a href="{!! route('antMiners.show', [$antMiner->id]) !!}"><i class="ion-cube"></i>  {!! $antMiner->title !!}</a>
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
                <!-- Check status -->
                <td class="text-center">
                    <span style="margin-left: 3px;"><i class="fa {{$data[$antMiner->id]->ok ? 'fa-check-circle color-green' : 'fa-exclamation-circle color-red'}}"></i></span>
                </td>

                <!-- Check status -->
                <td class="text-center">
                    <span ><i class="fa fa-clock-o color-{{$data[$antMiner->id]['created_at']->diffInSeconds() > 300 ? 'red' : 'green'}}"></i></span>
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
                <td class="text-left" nowrap>


                @if($data[$antMiner->id])
                    @php
                        $board_freq = 0;
                        foreach($data[$antMiner->id]['chains'] as $chain_index => $chain_data)
                        {
                            $board_freq = $board_freq + $chain_data['brd_freq'];
                        }
                    @endphp
                    <a class="btn btn-default btn-xs freq">
                        <i class="fa fa-bar-chart"></i> {{round($board_freq / count($data[$antMiner->id]['chains']), 0)}}
                    </a>
                @endif
                </td>

                <!-- Fans -->
                <td class="text-left" nowrap>
                    @foreach($data[$antMiner->id]['fans'] as $fan_id => $fan_speed)
                        <button class="btn btn-default btn-xs fan"><i class="fa fa-life-ring"></i> {{$fan_speed}}</button>
                    @endforeach
                </td>

                <!-- Updated -->
                <td class="text-left small" nowrap>
                    @if($data[$antMiner->id]['created_at']->diffInMinutes() < 1)
                        {{$data[$antMiner->id]['created_at']->diffInSeconds()}}s
                    @else
                        {{$data[$antMiner->id]['created_at']->diffInMinutes()}}m
                    @endif
                        ago
                </td>
            @else
                @if($antMiner->active)
                    <td colspan="9" class="text-left">No data to display</td>
                @else
                    <td colspan="9" class="text-left">{{$antMiner->d_reason}}</td>
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
        </tbody>
    </table>
</div>
