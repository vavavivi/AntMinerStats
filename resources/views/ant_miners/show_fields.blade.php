@include('flash::message')
<div class="clearfix"></div>

<div class="row">
    @if($stats['summary'])
        <!-- STATUS INFO-->
        <div class="col-sm-12">
            <div class="box box-primary miner-info">
                <div class="box-body">
                    <div class="row">

                        <!-- Uptime -->
                        <div class="col-sm-2 col-xs-6 border-right">
                            <div class="description-block">
                                <span class="description-text"><i class="fa fa-clock-o fa-lg"></i> Uptime</span>
                                <div class="description-header">
                                    {{ gmdate('d',$stats['summary']['Elapsed']) - 1 }}d
                                    {{ gmdate('H',$stats['summary']['Elapsed']) }}
                                    :{{ gmdate('i',$stats['summary']['Elapsed']) }}
                                </div>
                            </div>
                        </div>

                        <!-- Hashrate -->
                        <div class="col-sm-2 col-xs-6 border-right">
                            <div class="description-block">
                                <span class="description-text"><i class="fa fa-bolt fa-lg"></i> Hashrate RT</span>
                                <div class="description-header">{!! round(intval($stats['summary']['GHS 5s'])/1000,2) !!}
                                    <small>Ths</small>
                                </div>
                            </div>
                        </div>

                        <!-- Hashrate -->
                        <div class="col-sm-2 col-xs-6 border-right">
                            <div class="description-block">
                                <span class="description-text"><i class="fa fa-bolt fa-lg"></i> Hashrate avg</span>
                                <div class="description-header">{!! round(intval($stats['summary']['GHS av'])/1000,2) !!}
                                    <small>Ths</small>
                                </div>
                            </div>
                        </div>

                        <!-- HW -->
                        <div class="col-sm-2 col-xs-6 border-right">
                            <div class="description-block">
                                <span class="description-text"><i class="fa fa-bug fa-lg"></i> HW errors</span>
                                <div class="description-header">{{$stats['summary']['Device Hardware%']}} %</div>
                            </div>
                        </div>

                        <!-- Blocks -->
                        <div class="col-sm-2 col-xs-6 border-right">
                            <div class="description-block">
                                <span class="description-text"><i class="fa fa-cubes fa-lg"></i> Blocks</span>
                                <div class="description-header">{{$stats['summary']['Found Blocks']}} </div>
                            </div>
                        </div>

                        <!-- Local Work -->
                        <div class="col-sm-2 col-xs-6 border-right">
                            <div class="description-block">
                                <span class="description-text"><i
                                            class="fa fa-database fa-lg"></i> Local Work</span>
                                <div class="description-header">{{number_format($stats['summary']['Local Work'])}} </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($stats['pools'])
        <!-- POOL INFO -->
        <div class="col-sm-12">
            <div class="box box-warning">
                <div class="box-body">
                    <div class="table-responsive">
                        <!-- POLL INFO -->
                        <table class="table table-bordered table-hover table-condensed">
                            <thead>
                            <tr>
                                <th class="text-center">Pool</th>
                                <th>URL</th>
                                <th>User</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Diff</th>
                                <th class="text-center hidden-xs">GetWorks</th>
                                <th class="text-center">Accepted</th>
                                <th class="text-center hidden-xs">Discarded</th>
                                <th class="text-center">Rejected</th>
                                <th class="text-center hidden-xs">LSTime</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($stats['pools'] as $pool)
                                <tr>
                                    <td class="text-center">{{$pool['POOL']}}</td>
                                    <td>{{$pool['URL']}}</td>
                                    <td>{{$pool['User']}}</td>
                                    <td class="text-center">{{$pool['Status']}}</td>
                                    <td class="text-center">{{$pool['Diff']}}</td>
                                    <td class="text-center hidden-xs">{{$pool['Getworks']}}</td>
                                    <td class="text-center">{{$pool['Accepted']}}</td>
                                    <td class="text-center hidden-xs">{{$pool['Discarded']}}</td>
                                    <td class="text-center">{{$pool['Rejected']}}</td>
                                    <td class="text-center hidden-xs">{{$pool['Last Share Time']}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($stats['stats'])
        <!-- CHIPS INFO -->
        <div class="col-sm-12">
            <div class="box box-success">
                <div class="box-body">
                    <div class="text-center table-responsive">
                        <table class="table table-td-valign-middle">
                            <thead>
                                <th class="text-center" width="10%"></th>
                                <th class="text-center" width="10%"><i class="fa fa-building-o"></i> Board</th>
                                <th class="text-center" width="10%"><i class="fa fa-thermometer-half"></i> Temp</th>
                                <th class="text-center" width="10%"><i class="fa fa-tachometer"></i> Freq</th>
                                <th class="text-center" width="10%"><i class="fa fa-microchip text-success"></i> Ok</th>
                                <th class="text-center" width="10%"><i class="fa fa-microchip text-danger"></i> Fail</th>
                                <th class="text-center" width="10%"></th>
                                <th class="text-center" width="100%"></th>
                            </thead>
                            <tbody>
                            @foreach($stats['stats']['chains'] as $chain_index => $chain_data)
                                <tr>
                                    @if($loop->first)
                                        <td class="text-center" rowspan="3">
                                            @foreach($stats['stats']['fans'] as $fan)
                                                @if($loop->first)
                                                    <img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTguMS4xLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDYxMiA2MTIiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDYxMiA2MTI7IiB4bWw6c3BhY2U9InByZXNlcnZlIiB3aWR0aD0iMzJweCIgaGVpZ2h0PSIzMnB4Ij4KPGc+Cgk8Zz4KCQk8cGF0aCBkPSJNNTE1LjQ5MSwzNDcuMjczTDM2NS4xNDgsMjk5LjE0Yy0wLjM1OC00LjQ3Ny0xLjIzMS04LjgwOS0yLjU3My0xMi45MzZjNi4zNDctMi4xNDMsMTIuODkyLTQuNDYsMTkuNTA2LTYuOTU1ICAgIGM1OS44MTUtMjIuNTU5LDk0LjI4NC00Ny43ODUsMTAyLjQ0Ny03NC45NzljNS40My0xOC4wOTEtMC4zNTQtMzYuMDM1LTE3LjE4Ny01My4zMzZjLTEzLjI3OS0xMy42NDktNDIuNjI4LTM0LjA3LTQzLjg3Mi0zNC45MzEgICAgYy00LjctMy4yNjItMTEuMTQyLTIuMTUyLTE0LjQ3OSwyLjQ4N2wtOTIuOTMxLDEyOS4wNzhjLTIuMzkzLTAuMzEtNC44My0wLjQ4OC03LjMwNy0wLjQ4OGMtMS43MDUsMC0zLjM5MSwwLjA4OS01LjA1OCwwLjIzOCAgICBjLTAuNDA4LTQ3LjUxNy02LjI5Ny0xMDguMDctMzEuMTktMTM1LjUzOWMtOS42NjktMTAuNjctMjEuNDQ5LTE2LjA4Mi0zNS4wMTUtMTYuMDgyYzAsMCwwLDAtMC4wMDIsMCAgICBjLTkuMzE2LDAtMTkuNDQ4LDIuNjYyLTMwLjEwOCw3LjkxMWMtMTMuMjA1LDYuNTA0LTMzLjIxNiwyMC44ODQtNDIuMTgxLDI3LjUwMmMtMi42MzEsMS45NDMtNC4zMTksMy4yMjMtNC41OTMsMy40MyAgICBjLTIuODQ1LDIuMTYyLTQuMjc4LDUuNTAxLTQuMTI3LDguODI1YzAuMDg5LDEuOTk2LDAuNzQ5LDMuOTg2LDIuMDE3LDUuNzE2bDk3Ljc5OSwxMzMuMzg3Yy0xLjA3NCwyLjY0Ni0xLjk0OSw1LjM5MS0yLjYxNyw4LjIxNyAgICBjLTMxLjk2Mi0xMC40MTgtNzIuMDQxLTIwLjc4Ny0xMDUuMDIzLTIwLjc4N2MtMjUuOTc1LDAtNDQuODI3LDYuNTU4LTU2LjAyNywxOS40OWMtOS44NywxMS4zOTUtMTMuNDM2LDI3LjE1Mi0xMC41OTQsNDYuODM4ICAgIGMyLjcyNSwxOC44NDQsMTQuNDY3LDUyLjYxLDE0Ljk2Nyw1NC4wMzljMS41MDQsNC4zMTUsNS41NTMsNy4wMjksOS44OTEsNy4wMjljMS4wOSwwLDIuMTk1LTAuMTcsMy4yODMtMC41M2wxNTkuMjA3LTUyLjQ5ICAgIGMxLjc2MywxLjcxMSwzLjYzMSwzLjMxOCw1LjYwNiw0Ljc5MWMtNS41MjQsNy41NjUtMTEuMjU4LDE1Ljc0My0xNi44OTcsMjQuMzE0Yy0zNS4xMzMsNTMuNDA2LTQ4LjE5MSw5NC4wNzUtMzguODExLDEyMC44NzIgICAgYzYuMjQzLDE3LjgzLDIxLjQ3MSwyOC45NSw0NS4yNjIsMzMuMDUyYzEyLjI4NiwyLjEyLDMxLjY4NywyLjU2NSw0NS44MDIsMi41NjVjNi4xMjUsMCwxMC4yMDktMC4wODksMTAuMjA5LTAuMDg5ICAgIGM1LjcxNi0wLjEyMiwxMC4yOC00LjgwNCwxMC4yNTUtMTAuNTIybC0wLjcwMS0xNjMuMTg3YzMuMTM2LTEuMjgzLDYuMTI2LTIuODQsOC45NTMtNC42NGM0LjYzOCw2LjMyMiw5LjU3LDEyLjg0MSwxNC44MTIsMTkuNDEzICAgIGMzOS42LDQ5LjYyNSw3NC4wMTEsNzQuNzg5LDEwMi4yNzgsNzQuNzg5YzEzLjMyMywwLDMyLjIwNi01LjY5Nyw0Ni41MDUtMzIuODQxYzguODcxLTE2Ljg0MiwxOS4yMzctNTEuMDYyLDE5LjY3Mi01Mi41MDkgICAgQzUyMy45ODEsMzU0LjgwNyw1MjAuOTM4LDM0OS4wMTcsNTE1LjQ5MSwzNDcuMjczeiBNMzA4Ljc1LDMzMi43MTFjLTE2LjAzMSwwLTI5LjAzMy0xMy0yOS4wMzMtMjkuMDM3ICAgIGMwLTE2LjAzNywxMy4wMDItMjkuMDM1LDI5LjAzMy0yOS4wMzVjMTYuMDM3LDAsMjkuMDM3LDEyLjk5OCwyOS4wMzcsMjkuMDM1QzMzNy43ODcsMzE5LjcxMiwzMjQuNzg3LDMzMi43MTEsMzA4Ljc1LDMzMi43MTF6IiBmaWxsPSIjMDAwMDAwIi8+CgkJPHBhdGggZD0iTTYwMC41MDcsMEgxMS40OTVDNS4xNDgsMCwwLjAwMSw1LjE0NywwLjAwMSwxMS40OTZ2NTg5LjAxYzAsNi4zNDksNS4xNDcsMTEuNDk0LDExLjQ5NCwxMS40OTRoNTg5LjAxICAgIGM2LjM0NywwLDExLjQ5NC01LjE0NSwxMS40OTQtMTEuNDk0VjExLjQ5NkM2MTIuMDAxLDUuMTQ3LDYwNi44NTQsMCw2MDAuNTA3LDB6IE0yOC4xNTQsNDYuOTY4ICAgIGMwLTEwLjM4OSw4LjQyNC0xOC44MTUsMTguODE3LTE4LjgxNWMxMC4zOTcsMCwxOC44MTcsOC40MjYsMTguODE3LDE4LjgxNWMwLDEwLjM5Ny04LjQyLDE4LjgxNy0xOC44MTcsMTguODE3ICAgIEMzNi41NzgsNjUuNzg0LDI4LjE1NCw1Ny4zNjQsMjguMTU0LDQ2Ljk2OHogTTMwNi4wMDEsNTUxLjg2OGMtMTM1Ljc4NSwwLTI0NS44Ny0xMTAuMDc5LTI0NS44Ny0yNDUuODY4ICAgIFMxNzAuMjE2LDYwLjEzMiwzMDYuMDAxLDYwLjEzMmMxMzUuNzgzLDAsMjQ1Ljg3NCwxMTAuMDc5LDI0NS44NzQsMjQ1Ljg2OFM0NDEuNzg0LDU1MS44NjgsMzA2LjAwMSw1NTEuODY4eiBNNTY1LjAzNSw1ODMuODQ5ICAgIGMtMTAuMzk3LDAtMTguODE3LTguNDI2LTE4LjgxNy0xOC44MTdjMC0xMC4zOTcsOC40Mi0xOC44MTUsMTguODE3LTE4LjgxNWMxMC4zODUsMCwxOC44MTMsOC40MiwxOC44MTMsMTguODE1ICAgIEM1ODMuODQ4LDU3NS40MjMsNTc1LjQyMiw1ODMuODQ5LDU2NS4wMzUsNTgzLjg0OXoiIGZpbGw9IiMwMDAwMDAiLz4KCTwvZz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K" />
                                                    <h5>{{$fan}} RPM</h5>
                                                @endif
                                            @endforeach
                                        </td>
                                    @endif
                                    <td class="text-center">#{{$chain_index}}</td>
                                    <td class="text-center">
                                        @foreach($chain_data['brd_temp'] as $brd_temp){{$brd_temp}}
                                        @if(!$loop->last) / @endif
                                        @endforeach
                                        &deg;C
                                    </td>
                                    <td class="text-center">{{$chain_data['brd_freq']}} <small class="hidden-xs">Mhz</small></td>
                                    <td class="text-center">{{$chain_data['chips_condition']['ok']}}</td>
                                    <td class="text-center">{{$chain_data['chips_condition']['er']}}</td>
                                    @if($loop->first)
                                        <td class="text-center" rowspan="3">
                                            @if(count($stats['stats']['fans']) == 2)
                                                @foreach($stats['stats']['fans'] as $fan)
                                                    @if($loop->last)
                                                        <img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTguMS4xLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDYxMiA2MTIiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDYxMiA2MTI7IiB4bWw6c3BhY2U9InByZXNlcnZlIiB3aWR0aD0iMzJweCIgaGVpZ2h0PSIzMnB4Ij4KPGc+Cgk8Zz4KCQk8cGF0aCBkPSJNNTE1LjQ5MSwzNDcuMjczTDM2NS4xNDgsMjk5LjE0Yy0wLjM1OC00LjQ3Ny0xLjIzMS04LjgwOS0yLjU3My0xMi45MzZjNi4zNDctMi4xNDMsMTIuODkyLTQuNDYsMTkuNTA2LTYuOTU1ICAgIGM1OS44MTUtMjIuNTU5LDk0LjI4NC00Ny43ODUsMTAyLjQ0Ny03NC45NzljNS40My0xOC4wOTEtMC4zNTQtMzYuMDM1LTE3LjE4Ny01My4zMzZjLTEzLjI3OS0xMy42NDktNDIuNjI4LTM0LjA3LTQzLjg3Mi0zNC45MzEgICAgYy00LjctMy4yNjItMTEuMTQyLTIuMTUyLTE0LjQ3OSwyLjQ4N2wtOTIuOTMxLDEyOS4wNzhjLTIuMzkzLTAuMzEtNC44My0wLjQ4OC03LjMwNy0wLjQ4OGMtMS43MDUsMC0zLjM5MSwwLjA4OS01LjA1OCwwLjIzOCAgICBjLTAuNDA4LTQ3LjUxNy02LjI5Ny0xMDguMDctMzEuMTktMTM1LjUzOWMtOS42NjktMTAuNjctMjEuNDQ5LTE2LjA4Mi0zNS4wMTUtMTYuMDgyYzAsMCwwLDAtMC4wMDIsMCAgICBjLTkuMzE2LDAtMTkuNDQ4LDIuNjYyLTMwLjEwOCw3LjkxMWMtMTMuMjA1LDYuNTA0LTMzLjIxNiwyMC44ODQtNDIuMTgxLDI3LjUwMmMtMi42MzEsMS45NDMtNC4zMTksMy4yMjMtNC41OTMsMy40MyAgICBjLTIuODQ1LDIuMTYyLTQuMjc4LDUuNTAxLTQuMTI3LDguODI1YzAuMDg5LDEuOTk2LDAuNzQ5LDMuOTg2LDIuMDE3LDUuNzE2bDk3Ljc5OSwxMzMuMzg3Yy0xLjA3NCwyLjY0Ni0xLjk0OSw1LjM5MS0yLjYxNyw4LjIxNyAgICBjLTMxLjk2Mi0xMC40MTgtNzIuMDQxLTIwLjc4Ny0xMDUuMDIzLTIwLjc4N2MtMjUuOTc1LDAtNDQuODI3LDYuNTU4LTU2LjAyNywxOS40OWMtOS44NywxMS4zOTUtMTMuNDM2LDI3LjE1Mi0xMC41OTQsNDYuODM4ICAgIGMyLjcyNSwxOC44NDQsMTQuNDY3LDUyLjYxLDE0Ljk2Nyw1NC4wMzljMS41MDQsNC4zMTUsNS41NTMsNy4wMjksOS44OTEsNy4wMjljMS4wOSwwLDIuMTk1LTAuMTcsMy4yODMtMC41M2wxNTkuMjA3LTUyLjQ5ICAgIGMxLjc2MywxLjcxMSwzLjYzMSwzLjMxOCw1LjYwNiw0Ljc5MWMtNS41MjQsNy41NjUtMTEuMjU4LDE1Ljc0My0xNi44OTcsMjQuMzE0Yy0zNS4xMzMsNTMuNDA2LTQ4LjE5MSw5NC4wNzUtMzguODExLDEyMC44NzIgICAgYzYuMjQzLDE3LjgzLDIxLjQ3MSwyOC45NSw0NS4yNjIsMzMuMDUyYzEyLjI4NiwyLjEyLDMxLjY4NywyLjU2NSw0NS44MDIsMi41NjVjNi4xMjUsMCwxMC4yMDktMC4wODksMTAuMjA5LTAuMDg5ICAgIGM1LjcxNi0wLjEyMiwxMC4yOC00LjgwNCwxMC4yNTUtMTAuNTIybC0wLjcwMS0xNjMuMTg3YzMuMTM2LTEuMjgzLDYuMTI2LTIuODQsOC45NTMtNC42NGM0LjYzOCw2LjMyMiw5LjU3LDEyLjg0MSwxNC44MTIsMTkuNDEzICAgIGMzOS42LDQ5LjYyNSw3NC4wMTEsNzQuNzg5LDEwMi4yNzgsNzQuNzg5YzEzLjMyMywwLDMyLjIwNi01LjY5Nyw0Ni41MDUtMzIuODQxYzguODcxLTE2Ljg0MiwxOS4yMzctNTEuMDYyLDE5LjY3Mi01Mi41MDkgICAgQzUyMy45ODEsMzU0LjgwNyw1MjAuOTM4LDM0OS4wMTcsNTE1LjQ5MSwzNDcuMjczeiBNMzA4Ljc1LDMzMi43MTFjLTE2LjAzMSwwLTI5LjAzMy0xMy0yOS4wMzMtMjkuMDM3ICAgIGMwLTE2LjAzNywxMy4wMDItMjkuMDM1LDI5LjAzMy0yOS4wMzVjMTYuMDM3LDAsMjkuMDM3LDEyLjk5OCwyOS4wMzcsMjkuMDM1QzMzNy43ODcsMzE5LjcxMiwzMjQuNzg3LDMzMi43MTEsMzA4Ljc1LDMzMi43MTF6IiBmaWxsPSIjMDAwMDAwIi8+CgkJPHBhdGggZD0iTTYwMC41MDcsMEgxMS40OTVDNS4xNDgsMCwwLjAwMSw1LjE0NywwLjAwMSwxMS40OTZ2NTg5LjAxYzAsNi4zNDksNS4xNDcsMTEuNDk0LDExLjQ5NCwxMS40OTRoNTg5LjAxICAgIGM2LjM0NywwLDExLjQ5NC01LjE0NSwxMS40OTQtMTEuNDk0VjExLjQ5NkM2MTIuMDAxLDUuMTQ3LDYwNi44NTQsMCw2MDAuNTA3LDB6IE0yOC4xNTQsNDYuOTY4ICAgIGMwLTEwLjM4OSw4LjQyNC0xOC44MTUsMTguODE3LTE4LjgxNWMxMC4zOTcsMCwxOC44MTcsOC40MjYsMTguODE3LDE4LjgxNWMwLDEwLjM5Ny04LjQyLDE4LjgxNy0xOC44MTcsMTguODE3ICAgIEMzNi41NzgsNjUuNzg0LDI4LjE1NCw1Ny4zNjQsMjguMTU0LDQ2Ljk2OHogTTMwNi4wMDEsNTUxLjg2OGMtMTM1Ljc4NSwwLTI0NS44Ny0xMTAuMDc5LTI0NS44Ny0yNDUuODY4ICAgIFMxNzAuMjE2LDYwLjEzMiwzMDYuMDAxLDYwLjEzMmMxMzUuNzgzLDAsMjQ1Ljg3NCwxMTAuMDc5LDI0NS44NzQsMjQ1Ljg2OFM0NDEuNzg0LDU1MS44NjgsMzA2LjAwMSw1NTEuODY4eiBNNTY1LjAzNSw1ODMuODQ5ICAgIGMtMTAuMzk3LDAtMTguODE3LTguNDI2LTE4LjgxNy0xOC44MTdjMC0xMC4zOTcsOC40Mi0xOC44MTUsMTguODE3LTE4LjgxNWMxMC4zODUsMCwxOC44MTMsOC40MiwxOC44MTMsMTguODE1ICAgIEM1ODMuODQ4LDU3NS40MjMsNTc1LjQyMiw1ODMuODQ5LDU2NS4wMzUsNTgzLjg0OXoiIGZpbGw9IiMwMDAwMDAiLz4KCTwvZz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K" />
                                                        <h5>{{$fan}} RPM</h5>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </td>
                                        <td rowspan="3"></td>
                                        @else
                                        <td colspan="2" rowspan="3"></td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- GRAPHICS -->
    <div class="col-sm-12">
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">Graphics</h3>

            </div>
            <div class="box-body">

                <div id="temps1_div"></div>
                <div id="freqs_div"></div>
                <div id="hr_div"></div>
                <div id="hw_div"></div>
                <div id="cc_div"></div>

                <?= Lava::render('LineChart', 'Temps', 'temps1_div') ?>
                <?= Lava::render('LineChart', 'Freqs', 'freqs_div') ?>
                <?= Lava::render('LineChart', 'HashRate', 'hr_div') ?>
                <?= Lava::render('LineChart', 'HWERR', 'hw_div') ?>
                <?= Lava::render('LineChart', 'Chips', 'cc_div') ?>

            </div>
        </div>
    </div>
</div>







