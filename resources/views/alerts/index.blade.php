@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Alerts</h1>
        <h1 class="pull-right">
            <div class="input-group">
                <button type="button" class="btn btn-primary btn-sm checkbox-toggle"><i class="fa fa-check-square-o"></i></button>
                <button type="button" class="btn btn-danger btn-sm checkbox-trash"><i class="fa fa-trash-o"></i></button>
            </div>
        </h1>
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
                                    <td>
                                        <input type="checkbox" name="messages[]" class="checkbox" value="{{$alert->id}}">
                                    </td>
                                    <td class="mailbox-nam1e">
                                        <a href="{{route('alerts.read',$alert->id)}}">{{$alert->antMiner->title}}</a>
                                    </td>
                                    <td class="mailbox-subject">
                                        {!! $alert->status == 'new' ? '<b>' : '' !!}{{$alert->subject}}{!!$alert->status == 'new' ? '</b>' : '' !!} - {!! $alert->body !!}
                                    </td>
                                    <td class="mailbox-date">{{$alert->created_at->diffForHumans()}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="box-body no-padding">
                    <div class="table-responsive mailbox-messages">
                        <table class="table table-hover table-striped">
                            <tbody>
                                <tr>
                                    <td class="text-center">
                                        <br>
                                        <p>No alerts found...</p>
                                        <br>
                                    </td>

                                </tr>
                            </tbody>
                        </table>
                    </div>
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