<div id="layoutSidenav_nav">
    <nav class="sidenav shadow-right sidenav-light">
        <div class="sidenav-menu">
            <div class="nav accordion" id="accordionSidenav">

                @if(auth()->check())
                    <div class="sidenav-menu-heading"> Community</div>
                    <a class="nav-link @if(\Request::route()->getName() == 'dashboard') active @endif"
                       href="{{route('dashboard')}}">
                        <i data-feather="calendar"></i> &nbsp
                        Dashboard
                    </a>
                    <a class="nav-link @if(\Request::route()->getName() == 'create') active @endif"
                       href="{{route('create')}}">
                        <i data-feather="calendar"></i> &nbsp
                        Chiedi un consiglio
                    </a>

                    <a class="nav-link @if(\Request::route()->getName() == 'my') active @endif" href="{{route('my')}}">
                        <i data-feather="calendar"></i> &nbsp
                        Le mie domande
                    </a>

                    @if(auth()->user()->role == \App\Enum\Role::SUPERADMIN)
                        <div class="sidenav-menu-heading">Logs</div>
                        <a class="nav-link" href="{{route('admin.logs')}}">
                            <i data-feather="eye"></i> &nbsp
                            Guarda
                        </a>

                        <div class="sidenav-menu-heading">Domande</div>
                        <a class="nav-link @if(\Request::route()->getName() == 'admin.create') active @endif"
                           href="{{route('admin.create')}}">
                            <i data-feather="eye"></i> &nbsp
                            Crea una domanda
                        </a>

                        <div class="sidenav-menu-heading">Players</div>
                        <a class="nav-link" href="{{route('admin.player.import')}}">
                            <i data-feather="database"></i> &nbsp
                            Import la lista
                        </a>

                    @endif

                @endif
            </div>
        </div>
        @if(auth()->check())
        <div class="sidenav-footer">
            <div class="sidenav-footer-content">
                <div class="sidenav-footer-subtitle">Loggato come:</div>
                <div class="sidenav-footer-title">{{auth()->user()->name}}</div>
            </div>
        </div>
            @endif
    </nav>
</div>
