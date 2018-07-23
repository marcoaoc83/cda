<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="{{url('/')}}/admin/" class="site_title"><span class="image"><img src="/images/logo-branco.png" alt="CDA-e" /></span></a>
        </div>

        <div class="clearfix"></div>

        <!-- menu profile quick info -->
        <div class="profile">
            <div class="profile_pic">
                <img src="/images/user.png" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
                <span>Olá,</span>
                <h2>{{auth()->user()->name}}</h2>
            </div>
        </div>
        <!-- /menu profile quick info -->

        <br />

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <h3>&nbsp;</h3>
                <ul class="nav side-menu">
                    <li><a><i class="fa fa-edit"></i>Cadastros<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ route('admin.canal') }}">Canal</a></li>
                            <li><a href="{{ route('carteira.index') }}">Carteira</a></li>
                            <li><a href="{{ route('evento.index') }}">Evento</a></li>
                            <li><a href="{{ route('execfila.index') }}">Execução Fila</a></li>
                            <li><a href="{{ route('fila.index') }}">Fila Trabalho</a></li>
                            <li><a href="{{ route('admin.modelo') }}">Modelo Comunicação</a></li>
                            <li><a href="{{ route('regcalc.index') }}">Regra Calculo</a></li>
                            <li><a href="{{ route('pessoa.index') }}">Pessoa</a></li>
                            <li><a href="{{ route('admin.tabsys') }}">Tabelas Sistema</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-cogs"></i>Configurações <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ route('admin.users') }}">Usuários</a></li>
                            <li><a href="{{ route('tarefas.index') }}">Tarefas</a></li>
                            <li class="active"><a>Importar / Exportar<span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu" style="display: block;">
                                    <li class="sub_menu"><a href="{{ route('implayout.index') }}">Layout Importação</a></li>
                                    <li><a href="{{ route('importacao.index') }}">Importação</a></li>

                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-globe"></i>Portal<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ route('portal.index') }}">Configurações</a></li>
                            <li><a href="{{ route('faq.index') }}">FAQ</a></li>
                            <li><a href="{{ route('solicitar_acesso.index') }}">Solicitaçoes de Acesso</a></li>
                        </ul>
                    </li>
                </ul>
            </div>

        </div>
        <!-- /sidebar menu -->

        @include('partials._sidenav_footer')
    </div>
</div>