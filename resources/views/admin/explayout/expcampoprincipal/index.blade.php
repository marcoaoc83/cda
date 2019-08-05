<div class="x_panel" id="pnExpCampoPrincipal">
    <div class="x_title">
        <h2>Campos do Arquivo Principal <small></small></h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content x_title profile_title">
        <a class="btn btn-default btn-xs" id="btInserir"  data-toggle="modal" data-target="#myModalExpCampoPrincipal">
            <i class="fa fa-plus-square"> Inserir</i>
        </a>
        @include('admin.explayout.expcampoprincipal.create')
        <a class="btn btn-default btn-xs disabled"   data-toggle="modal" data-target="#myModalExpCampoPrincipalEdita" id="btEditar">
            <i class="fa fa-pencil-square-o"> Editar</i>
        </a>
        @include('admin.explayout.expcampoprincipal.edit')
        <a class="btn btn-default btn-xs disabled" id="btDeletar">
            <i class="fa fa-trash"> Deletar</i>
        </a>
    </div>
    <div class="x_content">

        <table id="tbExpCampoPrincipal" class="table table-hover table-bordered table-striped datatable display responsive nowrap" style="width:100%">
            <thead>
            <tr>
                <th>Ordem</th>
                <th>Título</th>
                <th>Nome Campo BD</th>
            </tr>
            </thead>
        </table>
    </div>
</div>
@push('scripts')
    @include('admin.explayout.expcampoprincipal.js.script');
@endpush
