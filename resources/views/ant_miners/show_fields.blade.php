<div class="col-md-12">
    <!-- /.box -->
    <div class="box">
        <div class="box-body">
            <table class="table table-bordered table-hover">
                <tbody><tr>
                    <th>Miner ID</th>
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
                <tr>
                    <td>{!! $antMiner->id !!}</td>
                    <td>
                        {{$stats['stats']['Type']}}: {!! $antMiner->title !!}
                        <p>
                            <small>
                                {!! $antMiner->username !!} @ {!! $antMiner->host !!}:{!! $antMiner->port !!}
                            </small>
                        </p>

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
        </div>

    <!-- /.box -->
        <div class="box-body">
            <table class="table table-bordered table-hover">
                <tbody><tr>
                    <th>Pool</th>
                    <th>URL</th>
                    <th>User</th>
                    <th>Status</th>
                    <th>Diff</th>
                    <th>Rejected</th>
                    <th>LSTime</th>
                </tr>
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
        </div>
    </div>

    <!-- /.box -->
        @if($antMiner->type == 'bmminer')
            <div class="box-body">
                <table class="table table-bordered table-hover">
                    <tbody><tr>
                        <th>Chain#</th>
                        <th>ASIC#</th>
                        <th>Frequency</th>
                        <th>Temp1</th>
                        <th>Temp2</th>
                        <th>ASIC status</th>
                    </tr>
                    @foreach($stats['selected']['chains'] as $chain_index => $chain_data)
                        <tr>
                            <td>{{$chain_index}}</td>
                            <td>{{$chain_data['chips']}}</td>
                            <td>{{$chain_data['brd_freq']}}</td>
                            <td>{{$chain_data['brd_temp1']}}</td>
                            <td>{{$chain_data['brd_temp2']}}</td>
                            <td>
                                @foreach($chain_data['chips_stat'] as $chip)
                                    @if($chip == 'o')
                                        <span class="pull-left bg-aqua">{{$chip}}</span>
                                    @else
                                        <span class="pull-right bg-red">x</span>
                                    @endif
                                @endforeach
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        @else
            <div class="box-body">
                <table class="table table-bordered table-hover">
                    <tbody><tr>
                        <th>Chain#</th>
                        <th>ASIC#</th>
                        <th>Frequency</th>
                        <th>Temp</th>
                        <th>ASIC status</th>
                    </tr>
                    @foreach($stats['selected']['chains'] as $chain_index => $chain_data)
                        <tr>
                            <td>{{$chain_index}}</td>
                            <td>{{$chain_data['chips']}}</td>
                            <td>{{$stats['stats']['frequency']}}</td>
                            <td>{{$chain_data['brd_temp']}}</td>
                            <td>
                                @foreach($chain_data['chips_stat'] as $chip)
                                    @if($chip == 'o')
                                        <span class="pull-left bg-aqua">{{$chip}}</span>
                                    @else
                                        <span class="pull-right bg-red">x</span>
                                    @endif
                                @endforeach
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        @endif
        <div class="box-body">
            <table class="table table-bordered table-hover">
                <tbody>
                <tr>
                    <th>Fan#</th>
                    <th>Fan#</th>
                </tr>
                    <tr>
                        @foreach($stats['selected']['fans'] as $fan)
                            <td>{{$fan}}</td>
                        @endforeach

                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
