@extends('layouts.app')


@section('title',"Alets -")

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Alert list</h1>
        <div class="btn-inline">
            <button type="button" class="btn btn-primary btn-sm checkbox-toggle"><i class="fa fa-check-square-o"></i></button>
            <button type="button" class="btn btn-danger btn-sm checkbox-trash"><i class="fa fa-trash-o"></i></button>
        </div>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        @include('flash::message')

        <div class="clearfix"></div>

        <div class="box box-primary">
            @if($alerts->count() > 0)
                <div class="box-body">
                    <div class="table-responsive mailbox-messages">
                        <table class="table table-hover table-striped">
                            <tbody>
                            @foreach($alerts as $alert)
                                <tr>
                                    <td width="1%" class="text-center">
                                        <input type="checkbox" name="messages[]" class="checkbox" value="{{$alert->id}}">
                                    </td>
                                    <td width="170" class="text-center" nowrap>{{$alert->created_at->format('H:i:s | d-m-Y')}}</td>
                                    <td class="text-left">
                                        {!! $alert->status == 'new' ? '<b>' : '' !!}{!! $alert->body !!}{!!$alert->status == 'new' ? '</b>' : '' !!}
                                    </td>
                                    <td class="text-center">
                                        <a href="{{route('alerts.read',$alert->id)}}" class="btn btn-xs btn-default"><i class="fa fa-check"></i> </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="box-body no-padding">
                    <p class="text-center m-20">No alerts found... ;-)</p>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(".checkbox-toggle").click(function () {
            var clicks = $(this).data('clicks');

            if (clicks == null){
                clicks = true;
            }

            if (clicks) {
                //Uncheck all checkboxes
                $(".mailbox-messages input[type='checkbox']").prop('checked', true);
            } else {
                //Check all checkboxes
                $(".mailbox-messages input[type='checkbox']").prop('checked', false);
            }
            $(this).data("clicks", !clicks);
        });

        $(".checkbox-trash").click(function () {
            var data = { 'messages[]': [] };

            $(":checked").each(function() {
                data['messages[]'].push($(this).val());
            });

            console.log(data);

            $.ajax({
                type: "POST",
                url: "{{route('alerts.purge')}}",
                dataType: "json",
                data: {
                    messages: data['messages[]'],
                    _token  : '{{ csrf_token() }}'
                },
                success: function(a) {
                    location.reload();
                }
            });

        });
    </script>
@endsection