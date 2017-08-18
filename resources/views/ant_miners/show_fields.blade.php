<div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-blue">
            <span class="info-box-icon"><i class="fa fa-cog fa-spin"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Current speed</span>
                <span class="info-box-number">{{$stats['summary']['GHS 5s']}} GH/s</span>

                <div class="progress">
                    <div class="progress-bar"
                         style="width: @if($stats['stats']['Type'] == "Antminer S7") {{ round(($stats['summary']['GHS 5s']/5200)*100) }}%
                         @elseif ($stats['stats']['Type'] == "Antminer S9") {{ round(($stats['summary']['GHS 5s']/13000)*100) }}%
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
        <div class="info-box bg-aqua">
            <span class="info-box-icon"><i class="fa fa-cogs"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Average speed</span>
                <span class="info-box-number">{{$stats['summary']['GHS av']}} GH/s</span>

                <div class="progress">
                    <div class="progress-bar" style="width: 70%"></div>
                </div>
                <span class="progress-description">
                    24 hours statistics
                  </span>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-green">
            <span class="info-box-icon"><i class="fa fa-rocket"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Uptime</span>
                <span class="info-box-number">{{ $stats['summary']['When'] }}</span>

            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-red">
            <span class="info-box-icon"><i class="fa fa-rocket"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Uptime</span>
                <span class="info-box-number">{{ $stats['summary']['When'] }}</span>

            </div>
        </div>
    </div>
</div>


<!-- COMMON INFO -->
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
        <td>{{$stats['summary']['When']}}</td>
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

<!-- POLL INFO -->
<table class="table table-bordered table-hover">
    <thead>
        <tr>
        <th>Pool</th>
        <th>URL</th>
        <th>User</th>
        <th>Status</th>
        <th>Diff</th>
        <th>Rejected</th>
        <th>LSTime</th>
    </tr>
    </thead>
    <tbody>
    @foreach($stats['pools'] as $pool)
        <tr>
            <td>{{$pool['POOL']}}</td>
            <td>{{$pool['URL']}}</td>
            <td>{{$pool['User']}}</td>
            <td>{{$pool['Status']}}</td>
            <td>{{$pool['Diff']}}</td>
            <td>{{$pool['Rejected']}}</td>
            <td>{{$pool['Last Share Time']}}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<!-- CHIPS INFO -->
@if($antMiner->type == 'bmminer')
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
@else
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
@endif
<!-- FANS -->
<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Fan#</th>
            <th>Fan#</th>
        </tr>
    </thead>
    <tbody>
    <tr>
        @foreach($stats['selected']['fans'] as $fan)
            <td>{{$fan}}</td>
        @endforeach
    </tr>
    </tbody>
</table>
