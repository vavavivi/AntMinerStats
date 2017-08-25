@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Monitoring</h1>
        <h1 class="pull-right">
           <a class="btn btn-sm btn-primary pull-right" href="{!! route('antMiners.create') !!}">Add miner <i class="fa fa-plus"></i> </a>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="m-t-5">
            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true"><i class="fa fa-table"></i> Table mode</a></li>
                    <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false"><i class="fa fa-th-large"></i> Widget mode</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <div class="table-responsive">
                            @include('ant_miners.table')
                        </div>
                    </div>

                    <div class="tab-pane" id="tab_2">
                        @include('ant_miners.widgets')
                    </div>
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- nav-tabs-custom -->
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script>
        $(function () {

            'use strict';

            // Make the dashboard widgets sortable Using jquery UI
            $('.connectedSortable').sortable({
                placeholder         : 'sort-highlight',
                connectWith         : '.connectedSortable',
                handle              : '.box-header',
                forcePlaceholderSize: true,
                zIndex              : 999999,
                scrollSensitivity   : 100,
                revert              : 200,
                helper              : 'clone',
                tolerance           : 'pointer'
            });

            $('.connectedSortable .box-header').css('cursor', 'move');

            // Active tab save to cookie
            jQuery('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
                //save the latest tab using a cookie:
                jQuery.cookie('last_tab', jQuery(e.target).attr('href'));
            });

            //activate latest tab, if it exists:
            var lastTab = jQuery.cookie('last_tab');
            if (lastTab) {
                jQuery('ul.nav-tabs').children().removeClass('active')
                jQuery('a[href='+ lastTab +']').parents('li:first').addClass('active');
                jQuery('#tab_1').removeClass('in');
                jQuery('#tab_1').removeClass('active');
                jQuery(lastTab).addClass('active');
                jQuery(lastTab).addClass('in');
            }
        });

    </script>
@endsection

