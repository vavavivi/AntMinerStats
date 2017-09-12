<!-- DASHBOARD -->
<li class="{{ Route::is('home') ? 'active' : '' }}">
    <a href="/"><i class="fa fa-desktop"></i> <span>Dashboard</span></a>
</li>

<!-- MINER STATUS -->
<li class="{{ Route::is('antMiners.index') ? 'active' : '' }}">
    <a href="{!! route('antMiners.index') !!}"><i class="fa fa-bar-chart"></i> <span>Monitoring</span></a>
</li>

<!-- ALERTS -->
<li class="{{ Request::is('alerts*') ? 'active' : '' }}">
    <a href="{!! route('alerts.index') !!}">
        <i class="fa fa-exclamation-triangle"></i>
        <span>Alerts</span>
        @if(Auth::user()->alerts->where('status','new')->count() > 0)
            <span class="pull-right-container">
              <span class="label label-danger pull-right">{{Auth::user()->alerts->where('status','new')->count()}}</span>
            </span>
        @endif
    </a>
</li>

<!-- MINER LIST -->
<li class="treeview {{ Route::is('antMiners.show') ? 'active' : '' }}">
    <a href="#">
        <i class="ion-cube"></i>
        <span>AntMiners</span>
        <span class="pull-right"><i class="fa fa-angle-down pull-right"></i></span>
    </a>
    <ul class="treeview-menu">
        @foreach(Auth::user()->miners as $antMiner)
            <li class="treeview {{ Request::url() == route('antMiners.show',$antMiner->id)  ? 'active' : '' }}">
                <a href="{!! route('antMiners.show', $antMiner->id) !!}"><i class="fa fa-cube"></i> {{$antMiner->location ? $antMiner->location->title : ''}}{{$antMiner->location ? ' / ' : ''}} {{$antMiner->title}}</a>
            </li>
        @endforeach
    </ul>
</li>

<li class="{{ Request::is('locations*') ? 'active' : '' }}">
    <a href="{!! route('locations.index') !!}"><i class="fa fa-edit"></i><span>Locations</span></a>
</li>

