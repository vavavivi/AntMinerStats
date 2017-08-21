<!-- COMMON INFO -->
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Miner status</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-green-active">
                    <span class="info-box-icon"><i class="fa fa-cog fa-spin"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Current hashrate</span>
                        <span class="info-box-number">{!! round(intval($stats['summary']['GHS 5s'])/1000,2) !!}</span>

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
                <div class="info-box bg-green">
                    <span class="info-box-icon"><i class="fa fa-cogs"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Avg. hashrate</span>
                        <span class="info-box-number">{!! round(intval($stats['summary']['GHS av'])/1000,2) !!}</span>

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
                <div class="info-box bg-olive">
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
                    <span class="info-box-icon"><i class="fa fa-times-circle"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">FANS (rpm)</span>
                        <span class="info-box-number"></span>

                        @foreach($stats['selected']['fans'] as $fan)
                            <span class="info-box-number">{{$fan}}</span>
                        @endforeach
                    </div>
                </div>
            </div>


            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-blue-active">
                    <span class="info-box-icon"><i class="fa fa-rocket"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Uptime</span>
                        <span class="info-box-number">{{ gmdate('d, H:i:s',$stats['summary']['Elapsed']) }}</span>
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

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-aqua">
                    <span class="info-box-icon"><i class="fa fa-star"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Found Blocks</span>
                        <span class="info-box-number">{{$stats['summary']['Found Blocks']}}</span>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>

<!-- CHIPS INFO -->
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
                <div class="col-md-4">
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
                                        <span class="description-text">Frequency</span>
                                        <h5 class="description-header">{{$chain_data['brd_freq']}} Mhz</h5>
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
            <div class="col-md-4">
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
                                    <span class="description-text">Frequency</span>
                                    <h5 class="description-header">{{$stats['stats']['frequency']}} Mhz</h5>
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

<!-- POOL INFO -->
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

<!-- GRAPHICS -->
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
