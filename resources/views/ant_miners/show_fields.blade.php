@include('flash::message')
<div class="clearfix"></div>

<div class="row">
    @if($stats['summary'])
        <!-- STATUS INFO-->
        <div class="col-sm-12">
            <div class="box box-primary miner-info">
                <div class="box-body">
                    <div class="row">

                        <!-- Hashrate -->
                        <div class="col-sm-2 col-xs-6 border-right">
                            <div class="description-block">
                                <span class="description-text"><i class="fa fa-clock-o fa-lg"></i> Hashrate</span>
                                <div class="description-header">
                                    {{ gmdate('d',$stats['summary']['Elapsed']) - 1 }}d
                                    {{ gmdate('H',$stats['summary']['Elapsed']) }}:{{ gmdate('i',$stats['summary']['Elapsed']) }}
                                </div>
                            </div>
                        </div>

                        <!-- Hashrate -->
                        <div class="col-sm-2 col-xs-6 border-right">
                            <div class="description-block">
                                <span class="description-text"><i class="fa fa-bolt fa-lg"></i> Hashrate RT</span>
                                <div class="description-header">{!! round(intval($stats['summary']['GHS 5s'])/1024,2) !!} <small>Ths</small></div>
                            </div>
                        </div>

                        <!-- Hashrate -->
                        <div class="col-sm-2 col-xs-6 border-right">
                            <div class="description-block">
                                <span class="description-text"><i class="fa fa-bolt fa-lg"></i> Hashrate avg</span>
                                <div class="description-header">{!! round(intval($stats['summary']['GHS av'])/1024,2) !!} <small>Ths</small></div>
                            </div>
                        </div>


                        <!-- HW -->
                        <div class="col-sm-2 col-xs-6 border-right">
                            <div class="description-block">
                                <span class="description-text"><i class="fa fa-bug fa-lg"></i> HW errors</span>
                                <div class="description-header">{{$stats['summary']['Device Hardware%']}} %</div>
                            </div>
                        </div>

                        <!-- Blocks -->
                        <div class="col-sm-2 col-xs-6 border-right">
                            <div class="description-block">
                                <span class="description-text"><i class="fa fa-cubes fa-lg"></i> Blocks</span>
                                <div class="description-header">{{$stats['summary']['Found Blocks']}} </div>
                            </div>
                        </div>

                        <!-- Local Work -->
                        <div class="col-sm-2 col-xs-6 border-right">
                            <div class="description-block">
                                <span class="description-text"><i class="fa fa-database fa-lg"></i> Local Work</span>
                                <div class="description-header">{{number_format($stats['summary']['Local Work'])}} </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        </div>
    @endif

    @if($stats['pools'])
        <!-- POOL INFO -->
        <div class="col-sm-12">
            <div class="box box-warning">
                <div class="box-body">
                    <div class="table-responsive">
                        <!-- POLL INFO -->
                        <table class="table table-bordered table-hover table-condensed">
                            <thead>
                            <tr>
                                <th class="text-center">Pool</th>
                                <th>URL</th>
                                <th>User</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Diff</th>
                                <th class="text-center hidden-xs">GetWorks</th>
                                <th class="text-center">Accepted</th>
                                <th class="text-center hidden-xs">Discarded</th>
                                <th class="text-center">Rejected</th>
                                <th class="text-center hidden-xs">LSTime</th>
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
                                    <td class="text-center hidden-xs">{{$pool['Getworks']}}</td>
                                    <td class="text-center">{{$pool['Accepted']}}</td>
                                    <td class="text-center hidden-xs">{{$pool['Discarded']}}</td>
                                    <td class="text-center">{{$pool['Rejected']}}</td>
                                    <td class="text-center hidden-xs">{{$pool['Last Share Time']}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($stats['stats'])
        <!-- CHIPS INFO -->
        <div class="col-sm-12">
            <div class="box box-success">
                <div class="box-body">
                    <div class="text-center">
                        <table class="table table-td-valign-middle">
                            <thead>
                                <th class="text-center" width="10%"></th>
                                <th class="text-center" width="10%"><i class="fa fa-building-o"></i> Board</th>
                                <th class="text-center" width="10%"><i class="fa fa-thermometer-half"></i> Temp</th>
                                <th class="text-center" width="10%"><i class="fa fa-tachometer"></i> Freq</th>
                                <th class="text-center" width="10%"><i class="fa fa-microchip text-success"></i> Ok</th>
                                <th class="text-center" width="10%"><i class="fa fa-microchip text-danger"></i> Fail</th>
                                <th class="text-center" width="10%"></th>
                            </thead>
                            <tbody>
                            @foreach($stats['stats']['chains'] as $chain_index => $chain_data)
                                <tr>
                                    @if($loop->first)
                                        <td class="text-center" rowspan="3">
                                            @foreach($stats['stats']['fans'] as $fan)
                                                @if($loop->first)
                                                    <i class="fa fa-cog fa-4x fa-spin"></i> <br>
                                                    <h3>{{$fan}} RPM</h3>
                                                @endif
                                            @endforeach
                                        </td>
                                    @endif
                                    <td class="text-center">#{{$chain_index}}</td>
                                    <td class="text-center">
                                        @foreach($chain_data['brd_temp'] as $brd_temp){{$brd_temp}}
                                        @if(!$loop->last) / @endif
                                        @endforeach
                                        &deg;C
                                    </td>
                                    <td class="text-center">{{$chain_data['brd_freq']}} <small class="hidden-xs">Mhz</small></td>
                                    <td class="text-center">{{$chain_data['chips_condition']['ok']}}</td>
                                    <td class="text-center">{{$chain_data['chips_condition']['er']}}</td>
                                    @if($loop->first)
                                        <td class="text-center" rowspan="3">
                                            @if(count($stats['stats']['fans']) == 2)
                                                @foreach($stats['stats']['fans'] as $fan)
                                                    @if($loop->last)
                                                        <i class="fa fa-cog fa-4x fa-spin"></i> <br>
                                                        <h3>{{$fan}} RPM</h3>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- GRAPHICS -->
    <div class="col-sm-12">
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">Graphics</h3>

            </div>
            <div class="box-body">

                <div id="temps1_div"></div>
                <div id="freqs_div"></div>
                <div id="hr_div"></div>
                <div id="hw_div"></div>
                <div id="cc_div"></div>

                <?= Lava::render('LineChart', 'Temps', 'temps1_div') ?>
                <?= Lava::render('LineChart', 'Freqs', 'freqs_div') ?>
                <?= Lava::render('LineChart', 'HashRate', 'hr_div') ?>
                <?= Lava::render('LineChart', 'HWERR', 'hw_div') ?>
                <?= Lava::render('LineChart', 'Chips', 'cc_div') ?>

            </div>
        </div>
    </div>
</div>







