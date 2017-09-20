<table class="table table-responsive" id="faqs-table">
    <thead>
        <th>Title</th>
        <th>Text</th>
        <th>Order</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($faqs as $faq)
        <tr>
            <td>{!! $faq->title !!}</td>
            <td>{!! $faq->text !!}</td>
            <td>{!! $faq->order !!}</td>
            <td>
                {!! Form::open(['route' => ['faq.destroy', $faq->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('faq.show', [$faq->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('faq.edit', [$faq->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>