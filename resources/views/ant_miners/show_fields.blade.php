<div class="row">

    <!-- COMMON INFO -->
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-green">
            <span class="info-box-icon"><i class="fa fa-rocket"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Uptime</span>
                <span class="info-box-number">{{ gmdate('d, H:i:s',$stats['summary']['Elapsed']) }}</span>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-yellow">
            <span class="info-box-icon"><i class="fa fa-wrench"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">BOARD FREQ</span>
                <span class="info-box-number">
                @if($antMiner->type == 'bmminer')
                        @foreach($stats['selected']['chains'] as $chain_index => $chain_data)
                            {{ $chain_data['brd_freq'] }} Mhz
                            @break
                        @endforeach
                    @else
                        {{$stats['stats']['frequency']}} Mhz
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-teal">
            <span class="info-box-icon"><i class="fa fa-times-circle fa-spin"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">FANS</span>
                <span class="info-box-number"></span>

                @foreach($stats['selected']['fans'] as $fan)
                    <span class="info-box-number">{{$fan}} rpm</span>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-aqua">
            <span class="info-box-icon"><i class="fa fa-star"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Found Blocks</span>
                <span class="info-box-number">{{$stats['summary']['Found Blocks']}}</span>
            </div>
        </div>
    </div>



    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-red">
            <span class="info-box-icon"><i class="fa fa-cog fa-spin"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Current speed</span>
                <span class="info-box-number">{{$stats['summary']['GHS 5s']}} GH/s</span>

                <div class="progress">
                    <div class="progress-bar"
                         style="width: @if($stats['stats']['Type'] == "Antminer S7") {{ round(($stats['summary']['GHS 5s']/5200)*100) }}%
                         @elseif ($stats['stats']['Type'] == "Antminer S9") {{ round(($stats['summary']['GHS 5s']/13000)*100) }}%
                         @elseif ($stats['stats']['Type'] == "Antminer T9") {{ round(($stats['summary']['GHS 5s']/12000)*100) }}%
                         @endif">
                    </div>
                </div>
                <span class="progress-description">
                    Last 5 minut statistics
                  </span>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-maroon">
            <span class="info-box-icon"><i class="fa fa-cogs"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Average speed</span>
                <span class="info-box-number">{{$stats['summary']['GHS av']}} GH/s</span>

                <div class="progress">
                    <div class="progress-bar" style="width: @if($stats['stats']['Type'] == "Antminer S7") {{ round(($stats['summary']['GHS av']/5200)*100) }}%
                    @elseif ($stats['stats']['Type'] == "Antminer S9") {{ round(($stats['summary']['GHS av']/13000)*100) }}%
                    @elseif ($stats['stats']['Type'] == "Antminer T9") {{ round(($stats['summary']['GHS av']/12000)*100) }}%
                    @endif"></div>
                </div>
                <span class="progress-description">
                    24 hours statistics
                  </span>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-blue">
            <span class="info-box-icon"><i class="fa fa-bar-chart"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Local, Utility work</span>
                <span class="info-box-number">{{$stats['summary']['Local Work']}}</span>
                <span class="info-box-number">{{$stats['summary']['Work Utility']}}</span>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-light-blue">
            <span class="info-box-icon"><i class="fa fa-bar-chart"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Utility</span>
                <span class="info-box-number">{{$stats['summary']['Utility']}}</span>
            </div>
        </div>
    </div>


</div>

{{--
<table class="table table-bordered table-hover">
    <thead>
        <tr>
        <th>Title</th>
        <th>Elapsed</th>
        <th>GH/S(5s)</th>
        <th>GH/S(avg)</th>
        <th>FoundBlocks</th>
        <th>LocalWork</th>
        <th>Utility</th>
        <th>Work Utility</th>
        <th>Best Share</th>
    </tr>
    </thead>
    <tbody>
        <tr>
        <td>
            {{$stats['stats']['Type']}}: {!! $antMiner->title !!}
        </td>
        <td>{{ gmdate('d, H:i:s',$stats['summary']['Elapsed']) }}</td>
        <td>{{$stats['summary']['GHS 5s']}}</td>
        <td>{{$stats['summary']['GHS av']}}</td>
        <td>{{$stats['summary']['Found Blocks']}}</td>
        <td>{{$stats['summary']['Local Work']}}</td>
        <td>{{$stats['summary']['Utility']}}</td>
        <td>{{$stats['summary']['Work Utility']}}</td>
        <td>{{$stats['summary']['Best Share']}}</td>
    </tr>
    </tbody>
</table>
--}}

<!-- CHIPS INFO -->
<div class="row">
@if($antMiner->type == 'bmminer')
    @foreach($stats['selected']['chains'] as $chain_index => $chain_data)
        <div class="col-md-4">
            <div class="box box-widget">
                <div class="box-header bg-success">
                    <h3 class="widget-user-username">BOARD CHAIN #{{$chain_index}}</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-4 border-right">
                            <div class="description-block">
                                <h5 class="description-header">{{$chain_data['chips']}}</h5>
                                <span class="description-text">Chips</span>
                            </div>
                        </div>
                        <div class="col-sm-4 border-right">
                            <div class="description-block">
                                <h5 class="description-header">{{$chain_data['brd_freq']}} Mhz</h5>
                                <span class="description-text">Frequency</span>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="description-block">
                                <h5 class="description-header">{{$chain_data['brd_temp1']}}/{{$chain_data['brd_temp2']}}</h5>
                                <span class="description-text">Temp</span>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="box-footer">
                    @foreach($chain_data['chips_stat'] as $chip)
                        @if($chip == 'o')
                            <span class="bg-success pull-left" style="font-size: 75%;">o</span>
                        @else
                            <span class="bg-red pull-left">x</span>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach
    {{--
    <table class="table table-bordered table-hover small">
        <thead>
            <tr>
            <th>Chain#</th>
            <th>ASIC#</th>
            <th>Frequency</th>
            <th>Temp1</th>
            <th>Temp2</th>
            <th>ASIC status</th>
        </tr>
        </thead>
        <tbody>
        @foreach($stats['selected']['chains'] as $chain_index => $chain_data)
            <tr>
                <td>{{$chain_index}}</td>
                <td>{{$chain_data['chips']}}</td>
                <td>{{$chain_data['brd_freq']}}</td>
                <td>{{$chain_data['brd_temp1']}}</td>
                <td>{{$chain_data['brd_temp2']}}</td>
                <td class="text-center small" nowrap>
                    @foreach($chain_data['chips_stat'] as $chip)
                        @if($chip == 'o')
                            <span class="bg-success pull-left">{{$chip}}</span>
                        @else
                            <span class="bg-red pull-left">x</span>
                        @endif
                    @endforeach
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
    --}}
@else
    @foreach($stats['selected']['chains'] as $chain_index => $chain_data)
    <div class="col-md-4">
        <div class="box box-widget">
            <div class="box-header bg-success">
                <h3 class="widget-user-username">BOARD # {{$chain_index}}</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-4 border-right">
                        <div class="description-block">
                            <h5 class="description-header">{{$chain_data['chips']}}</h5>
                            <span class="description-text">Chips</span>
                        </div>
                    </div>
                    <div class="col-sm-4 border-right">
                        <div class="description-block">
                            <h5 class="description-header">{{$stats['stats']['frequency']}} Mhz</h5>
                            <span class="description-text">Frequency</span>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="description-block">
                            <h5 class="description-header">{{$chain_data['brd_temp']}}</h5>
                            <span class="description-text">Temp</span>
                        </div>
                    </div>
                </div>

            </div>
            <div class="box-footer">
                @foreach($chain_data['chips_stat'] as $chip)
                    @if($chip == 'o')
                        <span class="bg-success pull-left" style="font-size: 75%;">o</span>
                    @else
                        <span class="bg-red pull-left">x</span>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    @endforeach
    {{--
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
            <th>Chain#</th>
            <th>ASIC#</th>
            <th>Frequency</th>
            <th>Temp</th>
            <th>ASIC status</th>
        </tr>
        </thead>
        <tbody>
        @foreach($stats['selected']['chains'] as $chain_index => $chain_data)
            <tr>
                <td>{{$chain_index}}</td>
                <td>{{$chain_data['chips']}}</td>
                <td>{{$stats['stats']['frequency']}}</td>
                <td>{{$chain_data['brd_temp']}}</td>
                <td class="text-center small">
                    @foreach($chain_data['chips_stat'] as $chip)
                        @if($chip == 'o')
                            <span class="bg-success pull-left">{{$chip}}</span>
                        @else
                            <span class="bg-red pull-left">x</span>
                        @endif
                    @endforeach
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    --}}
@endif
</div>


<!-- POLL INFO -->
<table class="table table-bordered table-hover table-condensed">
    <thead>
    <tr>
        <th class="text-center">Pool</th>
        <th>URL</th>
        <th>User</th>
        <th class="text-center">Status</th>
        <th class="text-center">Diff</th>
        <th class="text-center">Rejected</th>
        <th class="text-center">LSTime</th>
    </tr>
    </thead>
    <tbody>
    @foreach($stats['pools'] as $pool)
        <tr>
            <td class="text-center">{{$pool['POOL']}}</td>
            <td>{{$pool['URL']}}</td>
            <td>{{$pool['User']}}</td>
            <td class="text-center">{{$pool['Status']}}</td>
            <td class="text-center">{{$pool['Diff']}}</td>
            <td class="text-center">{{$pool['Rejected']}}</td>
            <td class="text-center">{{$pool['Last Share Time']}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
