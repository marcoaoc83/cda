<header class="pf-topo-site">
    <a class="pf-logo" href="{{route('portal.home')}}"><img src="{{asset('images/portal/'.$Var->port_logo_topo)}}" alt="{{$Var->port_titulo}}" /></a>
    <nav class="navbar navbar-expand-lg navbar-light border-bottom border-warning pf-nav d-flex justify-content-end">
        <button class="navbar-toggler border-white" type="button" data-toggle="collapse" data-target="#menu" aria-controls="menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse navbar-toggler-lg text-lg-right pf-menu" id="menu">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link @if(Route::current()->getName() == 'portal.home') active font-weight-bold @endif" href="{{route('portal.home')}}">Home <span class="sr-only">(current)</span></a></li>
                <li class="nav-item"><a class="nav-link @if(Route::current()->getName() == 'portal.legislacao') active font-weight-bold @endif" href="{{route('portal.legislacao')}}">Legislação</a></li>
                @if (session('acesso_cidadao'))
                    <li class="nav-item"><a class="nav-link @if(Route::current()->getName() == 'portal.debitos') active font-weight-bold @endif" href="{{route('portal.debitos')}}">Débitos</a></li>
                    <li class="nav-item"><a class="nav-link @if(Route::current()->getName() == 'portal.parcelamento') active font-weight-bold @endif" href="{{route('portal.parcelamento')}}">Parcelamento</a></li>
                    <li class="nav-item"><a class="nav-link @if(Route::current()->getName() == 'portal.guias') active font-weight-bold @endif" href="{{route('portal.guias')}}">Emissão Guias</a></li>
                    <li class="nav-item"><a class="nav-link @if(Route::current()->getName() == 'portal.dados') active font-weight-bold @endif" href="{{route('portal.dados')}}">Meus Dados</a></li>
                    <li class="nav-item"><a class="nav-link @if(Route::current()->getName() == 'portal.ajuda') active font-weight-bold @endif" href="{{route('portal.ajuda')}}">Ajuda</a></li>
                    <li class="nav-item"><a class="nav-link @if(Route::current()->getName() == 'portal.sair') active font-weight-bold @endif" href="{{route('portal.sair')}}">Sair</a></li>
                @else
                    <li class="nav-item"><a class="nav-link @if(Route::current()->getName() == 'portal.solicitacao') active font-weight-bold @endif" href="{{route('portal.solicitacao')}}">Solicitar Acesso</a></li>
                    <li class="nav-item"><a class="nav-link @if(Route::current()->getName() == 'portal.acesso') active font-weight-bold @endif" href="{{route('portal.acesso')}}">Área de Acesso</a></li>
                    <li class="nav-item"><a class="nav-link @if(Route::current()->getName() == 'portal.ajuda') active font-weight-bold @endif" href="{{route('portal.ajuda')}}">Ajuda</a></li>
                @endif

            </ul>
        </div>
    </nav>
</header>