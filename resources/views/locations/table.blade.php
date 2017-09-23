<table class="table table-hover" id="locations-table">
    <thead>
        <th>Name of Location</th>
        <th class="text-right">Action</th>
    </thead>
    <tbody>
    @foreach($locations as $location)
        <tr>
            <td width="50%">{!! $location->title !!}</td>
            <td class="text-right">
                {!! Form::open(['route' => ['locations.destroy', $location->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('locations.edit', [$location->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>