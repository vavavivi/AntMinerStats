<li class="{{ Request::is('antMiners*') ? 'active' : '' }}">
    <a href="{!! route('antMiners.index') !!}"><i class="fa fa-desktop"></i> <span>AntMINERS Overview</span></a>
</li>

<li class="treeview active">
    <a href="#">
        <i class="fa fa-folder"></i>
        <span>List of Miners</span>
        <span class="pull-right"><i class="fa fa-angle-down pull-right"></i></span>
    </a>
    <ul class="treeview-menu">

        @foreach(Auth::user()->miners as $antMiner)
            <li class="treeview {{ Request::is('antMiners.index') ? 'active' : '' }}">
                <a href="{!! route('antMiners.show', $antMiner->id) !!}"><i class="fa fa-cube"></i> {{$antMiner->title}}</a>
            </li>
        @endforeach
    </ul>
</li>

