<div class="x_panel" id="pnImpCampo">
    <div class="x_title">
        <h2>Campos <small></small></h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content x_title profile_title">
        <a class="btn btn-default btn-xs disabled" id="btInserir"  data-toggle="modal" data-target="#myModalImpCampo">
            <i class="fa fa-plus-square"> Inserir</i>
        </a>
        @include('admin.implayout.impcampo.create')
        <a class="btn btn-default btn-xs disabled"   data-toggle="modal" data-target="#myModalImpCampoEdita" id="btEditar">
            <i class="fa fa-pencil-square-o"> Editar</i>
        </a>
        @include('admin.implayout.impcampo.edit')
        <a class="btn btn-default btn-xs disabled" id="btDeletar">
            <i class="fa fa-trash"> Deletar</i>
        </a>
    </div>
    <div class="x_content">

        <table id="tbImpCampo" class="table table-hover table-bordered table-striped datatable display responsive nowrap" style="width:100%">
            <thead>
            <tr>
                <th>Ordem</th>
                <th>Nome Campo Arquivo</th>
                <th>Tabela BD</th>
                <th>Nome Campo BD</th>
                <th>Tipo Campo</th>
                <th>Valor Fixo</th>
                <th>Ord Table</th>
            </tr>
            </thead>
        </table>
    </div>
</div>
@push('scripts')
    @include('admin.implayout.impcampo.js.script');
@endpush
