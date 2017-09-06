@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="clearfix"></div>
        @include('adminlte-templates::common.errors')
        @include('flash::message')
        <div class="clearfix"></div>
        <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Alerts</h3>
                        </div>
                        @if($alerts->count() > 0)
                            <div class="box-body no-padding">
                                <div class="mailbox-controls">
                                    <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-check-square-o"></i></button>
                                    <button type="button" class="btn btn-default btn-sm checkbox-trash"><i class="fa fa-trash-o"></i></button>
                                </div>
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
                                    <!-- /.table -->
                                </div>
                                <!-- /.mail-box-messages -->
                            </div>
                            <div class="box-footer no-padding">
                                <div class="mailbox-controls">
                                    <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
                                    <button type="button" class="btn btn-default btn-sm checkbox-trash"><i class="fa fa-trash-o"></i></button>
                                    <div class="pull-right">
                                        1-50/200
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
                                            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button>
                                        </div>
                                        <!-- /.btn-group -->
                                    </div>
                                    <!-- /.pull-right -->
                                </div>
                            </div>
                        @else
                            <div class="box-body no-padding">
                                <div class="table-responsive mailbox-messages">
                                    <table class="table table-hover table-striped">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    no alerts
                                                </td>

                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- /.table -->
                                </div>
                                <!-- /.mail-box-messages -->
                            </div>
                        @endif

                    </div>
                    <!-- /. box -->
                </div>
                <!-- /.col -->
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