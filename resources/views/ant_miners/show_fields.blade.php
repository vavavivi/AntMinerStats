@include('flash::message')
<div class="clearfix"></div>
<div class="row">
    @if($stats['summary'])
        <!-- STATUS INFO-->
        <div class="col-sm-12">
            <div class="box box-primary miner-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Summary information</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <!-- HASHRATE -->
                        <div class="col-sm-2 col-xs-6 border-right">
                            <div class="description-block">
                                <div class="description-text"><img src="/images/icons/bl/004-bitcoin.png" width="48"><br> Hashrate </div>
                                <div class="description-header">{!! round(intval($stats['summary']['GHS 5s'])/1000,2) !!} / {!! round(intval($stats['summary']['GHS av'])/1000,2) !!}</div>
                            </div>
                        </div>

                        <!-- BOARD FREQ -->
                        <div class="col-sm-2 col-xs-6 border-right">
                            <div class="description-block">
                                <div class="description-text"><img src="/images/icons/bl/010-monitor.png" width="48"><br> Boards freq.</div>
                                <div class="description-header">
                                    @php
                                        $board_freq = 0;
                                        foreach($stats['stats']['chains'] as $chain_index => $chain_data)
                                        {
                                            $board_freq = $board_freq + $chain_data['brd_freq'];
                                        }
                                    @endphp
                                    {{round($board_freq / count($stats['stats']['chains']), 0)}} <small>Mhz</small>
                                </div>
                            </div>
                        </div>

                        <!-- HW -->
                        <div class="col-sm-2 col-xs-6 border-right">
                            <div class="description-block">
                                <div class="description-text"><img src="/images/icons/bl/007-alert.png" width="48"><br> HW errors</div>
                                <div class="description-header">{{$stats['summary']['Device Hardware%']}} %</div>
                            </div>
                        </div>

                        <!-- UPTIME -->
                        <div class="col-sm-2 col-xs-6 border-right">
                                <div class="description-block">
                                    <div class="description-text"><img src="/images/icons/bl/005-folder.png" width="48"><br> Uptime</div>
                                    <div class="description-header">{{ gmdate('d',$stats['summary']['Elapsed']) - 1 }}d {{ gmdate('H',$stats['summary']['Elapsed']) }}h {{ gmdate('i',$stats['summary']['Elapsed']) }}m  {{ gmdate('s',$stats['summary']['Elapsed']) }}s</div>
                                </div>
                            </div>

                        <!-- FANS -->
                        <div class="col-sm-2 col-xs-6 border-right">
                            <div class="description-block">
                                <div class="description-text"><img src="/images/icons/bl/fan.png" width="48"><br> Fans</div>
                                <div class="description-header">
                                    @foreach($stats['stats']['fans'] as $fan)
                                        {{$fan}}
                                    @endforeach
                                    <small>rpm</small>
                                </div>
                            </div>
                        </div>

                        <!-- BLOCKS -->
                        <div class="col-sm-2 col-xs-6 border-right">
                            <div class="description-block">
                                <div class="description-text"><img src="/images/icons/bl/012-bitcoin.png" width="48"><br> Found blocks</div>
                                <div class="description-header">{{$stats['summary']['Found Blocks']}}</div>
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
                <div class="box-header with-border">
                    <h3 class="box-title">Pool information</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
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
                <div class="box box-success collapsed-box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Chips status</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="text-center">
                            <table class="table table-td-valign-middle">
                                <thead>
                                <th class="text-center">Board</th>
                                <th class="text-center">Temp</th>
                                <th class="text-center">FREQ</th>
                                <th class="text-center">Chips</th>
                                <th class="text-left">Chips info</th>
                                </thead>
                                <tbody>
                                @foreach($stats['stats']['chains'] as $chain_index => $chain_data)
                                    <tr>
                                        <td class="text-center">#{{$chain_index}}</td>
                                        <td class="text-center">
                                            @foreach($chain_data['brd_temp'] as $brd_temp){{$brd_temp}}
                                            @if(!$loop->last) / @endif
                                            @endforeach
                                            &deg;
                                        </td>
                                        <td class="text-center">{{$chain_data['brd_freq']}} <small class="hidden-xs">Mhz</small></td>
                                        <td class="text-center">{{$chain_data['chips']}}</td>
                                        <td class="text-left">
                                            @foreach($chain_data['chips_stat'] as $chip)
                                                @if($chip == 'o')
                                                    <i class="fa fa-circle" style="color: gray; font-size: 40%;" ></i>
                                                @else
                                                    <i class="fa fa-times-circle" style="color: red; font-size: 40%;" ></i>
                                                @endif
                                            @endforeach
                                        </td>
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
        <div class="box box-danger collapsed-box">
            <div class="box-header with-border">
                <h3 class="box-title">Graphics</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">

                <div id="temps_div"></div>
                <div id="freqs_div"></div>
                <div id="hr_div"></div>
                <div id="hw_div"></div>
                <div id="cc_div"></div>

                <?= Lava::render('LineChart', 'Temps', 'temps_div') ?>
                <?= Lava::render('LineChart', 'Freqs', 'freqs_div') ?>
                <?= Lava::render('LineChart', 'HashRate', 'hr_div') ?>
                <?= Lava::render('LineChart', 'HWERR', 'hw_div') ?>
                <?= Lava::render('LineChart', 'Chips', 'cc_div') ?>

            </div>
        </div>
    </div>
</div>







