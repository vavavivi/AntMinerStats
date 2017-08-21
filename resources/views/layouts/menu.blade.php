<li class="{{ Route::is('home') ? 'active' : '' }}">
    <a href="/"><i class="fa fa-desktop"></i> <span>Dashboard</span></a>
</li>

<li class="{{ Route::is('antMiners.index') ? 'active' : '' }}">
    <a href="{!! route('antMiners.index') !!}"><i class="fa fa-bar-chart"></i> <span>Monitoring</span></a>
</li>

<li class="treeview {{ Route::is('antMiners.show') ? 'active' : '' }}">
    <a href="#">
        <i class="fa fa-folder"></i>
        <span>AntMiners</span>
        <span class="pull-right"><i class="fa fa-angle-down pull-right"></i></span>
    </a>
    <ul class="treeview-menu">
        @foreach(Auth::user()->miners as $antMiner)
            <li class="treeview">
                <a href="{!! route('antMiners.show', $antMiner->id) !!}"><i class="fa fa-cube"></i> {{$antMiner->title}}</a>
            </li>
        @endforeach
    </ul>
</li>


