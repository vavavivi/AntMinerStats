<table class="table table-responsive" id="antMiners-table">
    <thead>
        <th>Title</th>
        <th>Host</th>
        <th>Port</th>
        <th>Username</th>
        <th>Password</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($antMiners as $antMiner)
        <tr>
            <td>{!! $antMiner->title !!}</td>
            <td>{!! $antMiner->host !!}</td>
            <td>{!! $antMiner->port !!}</td>
            <td>{!! $antMiner->username !!}</td>
            <td>{!! $antMiner->password !!}</td>
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