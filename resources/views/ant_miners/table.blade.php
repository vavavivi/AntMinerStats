<table class="table table-responsive" id="antMiners-table">
    <thead>
        <th>Title</th>
        <th>GH/S(5s)</th>
        <th>Fans</th>
        <th>Brd Freq</th>
        <th>Brd Temp</th>
        <th>Chips Status</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($antMiners as $antMiner)
        <tr>
            <td>{!! $antMiner->title !!}</td>
            <td>{!! $data[$antMiner->id]['hash_rate'] !!}</td>
            <td>
                @foreach($data[$antMiner->id]['fans'] as $fan_id => $fan_speed)
                    <p>{{title_case($fan_id)}}: {{$fan_speed}}</p>
                @endforeach
            </td>

            <td>
                @foreach($data[$antMiner->id]['chains'] as $chain_index => $chain_data)
                    <p>{{$chain_data['brd_freq']}} Mhz</p>
                @endforeach
            </td>

            <td>
                @foreach($data[$antMiner->id]['chains'] as $chain_index => $chain_data)
                    @if($antMiner->type == 'bmminer')
                        <p>Board{{$chain_index}}: {{$chain_data['brd_temp1']}} °C / {{$chain_data['brd_temp2']}} °C</p>
                    @else
                        <p>Board{{$chain_index}}: {{$chain_data['brd_temp']}} °C</p>
                    @endif
                @endforeach
            </td>
            <td>
                @foreach($data[$antMiner->id]['chains'] as $chain_index => $chain_data)
                    <p>Board{{$chain_index}} chips: OK = {{$chain_data['chips_condition']['ok']}} / Fail = {{$chain_data['chips_condition']['er']}}</p>
                @endforeach
            </td>
            <td>
                {!! Form::open(['route' => ['antMiners.destroy', $antMiner->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('antMiners.show', [$antMiner->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('antMiners.edit', [$antMiner->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>