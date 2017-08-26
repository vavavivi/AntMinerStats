<div class="row">
    <!-- STATUS INFO-->
    <div class="col-sm-12">
        <div class="box box-primary miner-info">
            <div class="box-header with-border">
                <h3 class="box-title">Status information</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <!-- UPTIME -->
                    <div class="col-sm-2 col-xs-6 border-right">
                        <div class="description-block">
                            <span class="description-text"><i class="fa fa-rocket"></i> UPTIME</span>
                            <h5 class="description-header">{{ gmdate('d, H:i:s',$stats['summary']['Elapsed']) }}</h5>
                        </div>
                    </div>
                    <!-- HW -->
                    <div class="col-sm-2 col-xs-6 border-right">
                        <div class="description-block">
                            <span class="description-text"><i class="fa fa-star"></i> HW ERRORS</span>
                            <h5 class="description-header">&mdash;</h5>
                        </div>
                    </div>
                    <!-- HASHRATE -->
                    <div class="col-sm-2 col-xs-6 border-right">
                        <div class="description-block">
                            <span class="description-text"><i class="fa fa-cog fa-spin"></i> HASHRATE </span>
                            <h5 class="description-header">{!! round(intval($stats['summary']['GHS 5s'])/1000,2) !!} / {!! round(intval($stats['summary']['GHS av'])/1000,2) !!}</h5>
                        </div>
                    </div>
                    <!-- BOARD FREQ -->
                    <div class="col-sm-2 col-xs-6 border-right">
                        <div class="description-block">
                            <span class="description-text"><i class="fa fa-wrench"></i> BOARD FREQ.</span>
                            <h5 class="description-header">
                                @if($antMiner->type == 'bmminer')
                                    @foreach($stats['selected']['chains'] as $chain_index => $chain_data)
                                        {{ $chain_data['brd_freq'] }}  <small>Mhz</small>
                                        @break
                                    @endforeach
                                @else
                                    {{$stats['stats']['frequency']}} <small>Mhz</small>
                                @endif
                            </h5>
                        </div>
                    </div>
                    <!-- FANS -->
                    <div class="col-sm-2 col-xs-6 border-right">
                        <div class="description-block">
                            <span class="description-text"><img src="/images/fan.png" width="16"> FANS</span>
                            <h5 class="description-header">
                                @foreach($stats['selected']['fans'] as $fan)
                                    {{$fan}}
                                @endforeach
                                <small>rpm</small>
                            </h5>
                        </div>
                    </div>
                    <!-- BLOCKS -->
                    <div class="col-sm-2 col-xs-6 border-right">
                        <div class="description-block">
                            <span class="description-text"><i class="fa fa-star"></i> FOND BLOCKS</span>
                            <h5 class="description-header">{{$stats['summary']['Found Blocks']}}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- POOL INFO -->
    <div class="col-sm-12">
        <div class="box box-primary">
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
                </div>
            </div>
        </div>
    </div>

    <!-- GRAPHICS -->
    <div class="col-sm-8">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Graphics</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">

                <div id="temps_div"></div>
                <div id="freqs_div"></div>
                <div id="hr_div"></div>

                <?= Lava::render('LineChart', 'Temps', 'temps_div') ?>
                <?= Lava::render('LineChart', 'Freqs', 'freqs_div') ?>
                <?= Lava::render('LineChart', 'HashRate', 'hr_div') ?>

            </div>
        </div>
    </div>

    <!-- CHIPS INFO -->
    <div class="col-sm-4">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Chips status</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    @if($antMiner->type == 'bmminer')
                        @foreach($stats['selected']['chains'] as $chain_index => $chain_data)
                            <div class="col-sm-12">
                                <div class="box box-widget">
                                    <div class="box-header bg-maroon  text-center">
                                        <h3 class="box-title">BOARD #{{$chain_index}}</h3>
                                    </div>
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-xs-4 border-right">
                                                <div class="description-block">
                                                    <span class="description-text">Chips</span>
                                                    <h5 class="description-header">{{$chain_data['chips']}}</h5>
                                                </div>
                                            </div>
                                            <div class="col-xs-4 border-right">
                                                <div class="description-block">
                                                    <span class="description-text">FREQ</span>
                                                    <h5 class="description-header">{{$chain_data['brd_freq']}} <small>Mhz</small></h5>
                                                </div>
                                            </div>
                                            <div class="col-xs-4">
                                                <div class="description-block">
                                                    <span class="description-text">Temp</span>
                                                    <h5 class="description-header">{{$chain_data['brd_temp1']}} / {{$chain_data['brd_temp2']}}&deg;</h5>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="box-footer text-center">
                                        @foreach($chain_data['chips_stat'] as $chip)
                                            @if($chip == 'o')
                                                <i class="fa fa-circle" style="color: gray; font-size: 60%;" ></i>
                                            @else
                                                <i class="fa fa-circle-o" style="color: red; font-size: 60%;" ></i>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        @foreach($stats['selected']['chains'] as $chain_index => $chain_data)
                            <div class="col-sm-12">
                                <div class="box box-widget">
                                    <div class="box-header bg-maroon  text-center">
                                        <h3 class="box-title">CHAIN #{{$chain_index}}</h3>
                                    </div>
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-xs-4 border-right">
                                                <div class="description-block">
                                                    <span class="description-text">Chips</span>
                                                    <h5 class="description-header">{{$chain_data['chips']}}</h5>
                                                </div>
                                            </div>
                                            <div class="col-xs-4 border-right">
                                                <div class="description-block">
                                                    <span class="description-text">FREQ</span>
                                                    <h5 class="description-header">{{$stats['stats']['frequency']}} <small>Mhz</small></h5>
                                                </div>
                                            </div>
                                            <div class="col-xs-4">
                                                <div class="description-block">
                                                    <span class="description-text">Temp</span>
                                                    <h5 class="description-header">{{$chain_data['brd_temp']}}&deg;</h5>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="box-footer text-center">
                                        @foreach($chain_data['chips_stat'] as $chip)
                                            @if($chip == 'o')
                                                <i class="fa fa-circle" style="color: gray; font-size: 60%;" ></i>
                                            @else
                                                <i class="fa fa-circle-o" style="color: red; font-size: 60%;" ></i>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>







