<div class="row">
    @foreach($antMiners->sortBy('user_id') as $antMiner)

        <section class="col-xs-12 col-sm-6 col-lg-4 connectedSortable">

            <div class="box" style="border: 0px;">
{{--
                <div class="box-header @if($data[$antMiner->id]) bg-primary @else bg-red-active @endif">
                    <a href="{!! route('antMiners.show', [$antMiner->id]) !!}">
                        <!-- Check status -->
                        <span style="margin-left: 3px;"><i class="fa {{ $data[$antMiner->id]->ok ? 'fa-check-circle color-green' : 'fa-exclamation-circle color-red' }}"></i></span>
                        <h3 class="box-title">{!! $antMiner->title !!}</h3>
                    </a>
                    <div class="pull-right">
                        <div class='btn-group'>
                        @if($antMiner->url)
                            <a href="{{$antMiner->url}}" class='btn  btn-box-tool color-white' target="_blank"><i class="glyphicon glyphicon-share"></i></a>
                        @endif
                        {!! Form::open(['route' => ['antMiners.destroy', $antMiner->id], 'method' => 'delete']) !!}
                            <a href="{!! route('antMiners.edit', [$antMiner->id]) !!}" class='btn btn-box-tool color-white'><i class="fa fa-cogs"></i></a>
                            {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-box-tool color-white', 'onclick' => "return confirm('Are you sure?')"]) !!}
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
                <div class="box-body">
                @if($data[$antMiner->id])
                    <!-- COMMON INFO -->
                    <div class="row">

                        <!-- HASHRATE-->
                        <div class="col-xs-4">
                            <div class="description-block">
                                <span class="description-text small">HASH RATE</span>
                                @if (isset($antMiner->temp_limit))
                                    @if(round(intval($data[$antMiner->id]['hash_rate'])/1000,2) == 0)
                                        <h5 class="description-header">{!! number_format(round(intval($data[$antMiner->id]['hash_rate'])/1000,2),2) !!} <small>TH/s</small></h5>
                                    @elseif(round(intval($data[$antMiner->id]['hash_rate'])/1000,2) > $antMiner->temp_limit)
                                        <h5 class="description-header">{!! number_format(round(intval($data[$antMiner->id]['hash_rate'])/1000,2),2) !!}<small>TH/s</small></h5>
                                    @else
                                        <h5 class="description-header">{!! number_format(round(intval($data[$antMiner->id]['hash_rate'])/1000,2),2) !!} <small>TH/s</small></h5>
                                    @endif
                                @else
                                    <h5 class="description-header ">{!! number_format(round(intval($data[$antMiner->id]['hash_rate'])/1000,2),2) !!} <small>TH/s</small></h5>
                                @endif
                            </div>
                        </div>

                        <!-- B.FREQ -->
                        <div class="col-xs-4">
                            <div class="description-block">
                                <span class="description-text small">Board Freq</span>

                                @if($data[$antMiner->id])
                                    @php ( $board_freq = 0 )

                                    @foreach($data[$antMiner->id]['chains'] as $chain_index => $chain_data)
                                        @php ( $board_freq = $board_freq + round(intval($chain_data['brd_freq']),0) )
                                    @endforeach

                                    <h5 class="description-header">{{ round($board_freq/3,0) }} <small>Mhz</small></h5>

                                @else
                                    <h5 class="description-header"> 0</h5>
                                @endif
                            </div>
                        </div>

                        <!-- ERRORS-->
                        <div class="col-xs-4">
                            <div class="description-block">
                                <span class="description-text small">HW ERR</span>
                                <h5 class="description-header">{!! $data[$antMiner->id]['hw'] !!}<small>%</small></h5>
                            </div>
                        </div>
                    </div>
                    <hr style="margin: 12px 0px 5px 0px;">
                    <div class="row">
                        <!-- TEMP-->
                        <div class="col-xs-4 col-sm-4">
                            <div class="description-block">
                                <span class="description-text small">TEMP</span>
                                <div>

                                </div>
                            </div>
                        </div>

                        <!-- CHIPS -->
                        <div class="col-xs-4 col-sm-4">
                            <div class="description-block">
                                <span class="description-text small">CHIPS</span>
                                <div style="white-space: nowrap;">
                                    @if($data[$antMiner->id])
                                        @foreach($data[$antMiner->id]['chains'] as $chain_index => $chain_data)
                                            @if(intval($chain_data['chips_condition']['ok']) > 0)
                                                <span class="label bg-green"> <i class="fa fa-check"></i></span>
                                            @endif
                                            @if(intval($chain_data['chips_condition']['er']) > 0)
                                                <span class="label bg-red"> <i class="fa fa-times"></i></span>
                                            @endif
                                        @endforeach
                                    @else
                                        &mdash;
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- FAN -->
                        <div class="col-xs-4 col-sm-4">
                            <div class="description-block">
                                <span class="description-text small">FANs</span>
                                <div>
                                    @if($data[$antMiner->id])
                                        @foreach($data[$antMiner->id]['fans'] as $fan_id => $fan_speed)
                                            @if ($fan_speed > 1000)
                                                <span class="label bg-green"> <i class="fa fa-check"></i></span>
                                            @else
                                                <span class="label bg-red"> <i class="fa fa-times"></i></span>
                                            @endif
                                        @endforeach
                                    @else
                                        &mdash;
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                </div>
--}}
            </div>
        </section>
    @endforeach
</div>



