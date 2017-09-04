@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Alerts</h1>

    </section>
    <div class="content">
        <div class="clearfix"></div>
        @include('adminlte-templates::common.errors')
        @include('flash::message')
        <div class="clearfix"></div>
        <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <!-- /.box-header -->
                        <div class="box-body no-padding">
                            <div class="table-responsive mailbox-messages">
                                <table class="table table-hover table-striped">
                                    <tbody>
                                    @foreach($alerts as $alert)
                                        <tr>
                                            <td class="mailbox-name"><a href="{{route('alerts.read',$alert->id)}}">{{$alert->antMiner->title}}</a></td>
                                            <td class="mailbox-subject">
                                                {!! $alert->status == 'new' ? '<b>' : '' !!}{{$alert->subject}}{!!$alert->status == 'new' ? '</b>' : '' !!} - {!! $alert->body !!}
                                            </td>
                                            <td class="mailbox-attachment"></td>
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
                    </div>
                    <!-- /. box -->
                </div>
                <!-- /.col -->
            </div>
    </div>
@endsection

