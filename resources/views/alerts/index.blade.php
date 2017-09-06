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

                            <!-- /.box-tools -->
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body no-padding">
                            <div class="mailbox-controls">
                                <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-check-square-o"></i></button>
                                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
                            </div>
                            <div class="table-responsive mailbox-messages">
                                <table class="table table-hover table-striped">
                                    <tbody>

                                    @foreach($alerts as $alert)
                                        <tr>
                                            <td>
                                                <input type="checkbox">
                                            </td>
                                            <td class="mailbox-name">
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
                        <!-- /.box-body -->
                        <div class="box-footer no-padding">
                            <div class="mailbox-controls">
                                <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
                                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
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
                var clicks = true;
            }

            console.log(clicks);

            if (clicks) {
                //Uncheck all checkboxes
                $(".mailbox-messages input[type='checkbox']").prop('checked', true);
            } else {
                //Check all checkboxes
                $(".mailbox-messages input[type='checkbox']").prop('checked', false);
            }
            $(this).data("clicks", !clicks);
        });
    </script>
@endsection