<div class="row">
    @foreach($antMiners->sortBy('user_id') as $antMiner)

        <section class="col-xs-12 col-sm-6 col-lg-3 connectedSortable">

            <div class="box" style="border: 0px;">
                <div class="box-header @if($data[$antMiner->id]) bg-gray @else bg-red-active @endif">
                    <a href="{!! route('antMiners.show', [$antMiner->id]) !!}"><h3 class="box-title">{!! $antMiner->title !!}</h3></a>
                    <div class="box-tools pull-right">
                        @if($antMiner->url)
                            <a href="{{$antMiner->url}}" class='btn  btn-box-tool color-white' target="_blank"><i class="glyphicon glyphicon-share"></i></a>
                        @else
                            <a href="#" class='btn  btn-box-tool color-white disabled' target="_blank"><i class="glyphicon glyphicon-share"></i></a>
                        @endif
                        <a href="{!! route('antMiners.edit', [$antMiner->id]) !!}" class='btn btn-box-tool color-white'><i class="fa fa-cog"></i></a>
                        <button type="button" class="btn btn-box-tool color-white"><i class="fa fa-trash"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <!-- COMMON INFO -->
                    <div class="row">

                        <!-- HASHRATE-->
                        <div class="col-xs-4">
                            <div class="description-block">
                                <span class="description-text small">H.Rate</span>
                                @if (isset($antMiner->temp_limit))
                                    @if(round(intval($data[$antMiner->id]['hash_rate'])/1000,2) == 0)
                                        <h5 class="description-header">{!! round(intval($data[$antMiner->id]['hash_rate'])/1000,2) !!}</h5>
                                    @elseif(round(intval($data[$antMiner->id]['hash_rate'])/1000,2) > $antMiner->temp_limit)
                                        <h5 class="description-header">{!! round(intval($data[$antMiner->id]['hash_rate'])/1000,2) !!}</h5>
                                    @else
                                        <h5 class="description-header">{!! round(intval($data[$antMiner->id]['hash_rate'])/1000,2) !!}</h5>
                                    @endif
                                @else
                                    <h5 class="description-header ">{!! round(intval($data[$antMiner->id]['hash_rate'])/1000,2) !!}</h5>
                                @endif
                            </div>
                        </div>

                        <!-- B.FREQ -->
                        <div class="col-xs-4">
                            <div class="description-block">
                                <span class="description-text small">B.Freq</span>

                                @if($data[$antMiner->id])
                                    @php ( $board_freq = 0 )

                                    @foreach($data[$antMiner->id]['chains'] as $chain_index => $chain_data)
                                        @php ( $board_freq = $board_freq + round(intval($chain_data['brd_freq']),0) )
                                    @endforeach

                                    <h5 class="description-header">{{ round($board_freq/3,0) }} <small class="hidden-xs">Mhz</small></h5>

                                    @if(round($board_freq/3,0) > 774)
                                    <div class="progress progress-xxs">
                                        <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar"  style="width: 100%"></div>
                                    </div>
                                    @elseif(round($board_freq/3,0) > 749)
                                    <div class="progress progress-xxs">
                                        <div class="progress-bar progress-bar-warning progress-bar-striped" role="progressbar"  style="width: 60%"></div>
                                    </div>
                                    @else
                                    <div class="progress progress-xxs">
                                        <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar"  style="width: 30%"></div>
                                    </div>
                                    @endif
                                @else
                                    <h5 class="description-header"> 0</h5>
                                @endif
                            </div>
                        </div>

                        <!-- ERRORS-->
                        <div class="col-xs-4">
                            <div class="description-block">
                                <span class="description-text small">HW</span>
                                <h5 class="description-header">{!! $data[$antMiner->id]['hw'] !!}</h5>

                                @if($data[$antMiner->id]['hw'] > 0.01)
                                    <div class="progress progress-xxs">
                                        <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar"  style="width: 100%"></div>
                                    </div>
                                @elseif($data[$antMiner->id]['hw'] > 0.003)
                                    <div class="progress progress-xxs">
                                        <div class="progress-bar progress-bar-warning progress-bar-striped" role="progressbar"  style="width: 60%"></div>
                                    </div>
                                @else
                                    <div class="progress progress-xxs">
                                        <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar"  style="width: 30%"></div>
                                    </div>
                                @endif
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
                                    @if($data[$antMiner->id])
                                        @foreach($data[$antMiner->id]['chains'] as $chain_index => $chain_data)
                                            @if($antMiner->type == 'bmminer')
                                                @if(intval($chain_data['brd_temp1']) > 95 OR intval($chain_data['brd_temp2']) > 95)
                                                    @php $temp_check = 3; @endphp
                                                @elseif(intval($chain_data['brd_temp1']) > 88 OR intval($chain_data['brd_temp2']) > 88)
                                                    @php $temp_check = 2; @endphp
                                                @else
                                                    @php $temp_check = 1; @endphp
                                                @endif
                                            @else
                                                @if(intval($chain_data['brd_temp']) > 79)
                                                    @php $temp_check = 3; @endphp
                                                @elseif(intval($chain_data['brd_temp']) > 73)
                                                    @php $temp_check = 2; @endphp
                                                @else
                                                    @php $temp_check = 1; @endphp
                                                @endif
                                            @endif
                                        @endforeach

                                        @if ($temp_check == 3)
                                            <span class="label bg-red"> <i class="fa fa-times"></i></span>
                                        @elseif ($temp_check == 2)
                                            <span class="label bg-yellow"> <i class="fa fa-exclamation-triangle"></i></span>
                                        @else
                                            <span class="label bg-green"> <i class="fa fa-check"></i></span>
                                        @endif
                                    @else
                                       &mdash;
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- CHIPS -->
                        <div class="col-xs-12 col-sm-4">
                            <div class="description-block">
                                <span class="description-text small">CHIPS</span>
                                <div style="white-space: nowrap;">
                                    @if($data[$antMiner->id])
                                        @foreach($data[$antMiner->id]['chains'] as $chain_index => $chain_data)
                                            @if     (intval($chain_data['chips_condition']['ok']) > 0)
                                                <span class="label bg-green"> <i class="fa fa-check"></i></span>
                                            @elseif (intval($chain_data['chips_condition']['er']) > 0)
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
                        <div class="col-xs-12 col-sm-4 hidden-xs">
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

                    {{--
                    <table class="table table-bordered table-condensed small m-t-10 table-valign-middle">
                        <tbody>

                        <!-- TEMP -->
                        <tr>
                            <td class="text-center" width="15%"><b>TEMP</b></td>
                            <td class="text-center">
                                @if($data[$antMiner->id])
                                    @foreach($data[$antMiner->id]['chains'] as $chain_index => $chain_data)
                                        @if($antMiner->type == 'bmminer')
                                            <div class="btn-group">
                                                @if(intval($chain_data['brd_temp1']) > 95)
                                                    <span class="badge bg-red"> {{$chain_data['brd_temp1']}} | {{$chain_data['brd_temp2']}}°</span>
                                                @elseif(intval($chain_data['brd_temp1']) > 88)
                                                    <span class="badge bg-yellow"> {{$chain_data['brd_temp1']}} | {{$chain_data['brd_temp2']}}°</span>
                                                @else
                                                    <span class="badge bg-green"> {{$chain_data['brd_temp1']}} | {{$chain_data['brd_temp2']}}°</span>
                                                @endif
                                            </div>
                                        @else
                                            @if(intval($chain_data['brd_temp']) > 79)
                                                <span class="badge bg-red"> {{$chain_data['brd_temp']}}°</span>
                                            @elseif(intval($chain_data['brd_temp']) > 73)
                                                <span class="badge bg-yellow"> {{$chain_data['brd_temp']}}°</span>
                                            @else
                                                <span class="badge bg-green"> {{$chain_data['brd_temp']}}°</span>
                                            @endif
                                        @endif
                                    @endforeach
                                @else
                                    ERROR: Cannot fetch data
                                @endif
                            </td>
                        </tr>

                        <!-- CHIPS -->
                        <tr>
                            <td class="text-center" width="15%"><b>CHIPS</b></td>
                            <td class="text-center">
                                @if($data[$antMiner->id])
                                    @foreach($data[$antMiner->id]['chains'] as $chain_index => $chain_data)
                                        @if(intval($chain_data['chips_condition']['ok']) > 0)
                                            <span class="badge bg-green"> <i class="fa fa-check"></i> </span>
                                        @endif
                                        @if(intval($chain_data['chips_condition']['er']) > 0)
                                            <span class="badge bg-green"> <i class="fa fa-times"></i> </span>
                                        @endif
                                    @endforeach
                                @else
                                    ERROR: Cannot fetch data
                                @endif
                            </td>
                        </tr>

                        <!-- FANS -->
                        <tr>
                            <td class="text-center" width="15%"><b>FAN</b></td>
                            <td class="text-center">
                                @if($data[$antMiner->id])
                                @foreach($data[$antMiner->id]['fans'] as $fan_id => $fan_speed)
                                    @if ($fan_speed > 1000)
                                            <span class="badge bg-green">{{$fan_speed}}</span>
                                    @else
                                            <span class="badge bg-red">{{$fan_speed}}</span>
                                    @endif
                                @endforeach
                                @else
                                    ERROR: Cannot fetch data
                                @endif
                            </td>
                        </tr>

                        </tbody>
                    </table>
                    --}}
                </div>
            </div>

        </section>
    @endforeach
</div>



