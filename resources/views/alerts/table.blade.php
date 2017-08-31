<table class="table table-responsive" id="alerts-table">
    <thead>
        <th>Miner Id</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($alerts as $alert)
        <tr>
            <td>{!! $alert->miner_id !!}</td>
            <td>
                {!! Form::open(['route' => ['alerts.destroy', $alert->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('alerts.show', [$alert->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('alerts.edit', [$alert->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>