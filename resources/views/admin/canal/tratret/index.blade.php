<div class="x_panel" id="pnTratRet">
    <div class="x_title">
        <h2>Tratamento de Retorno<small></small></h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content x_title profile_title">
        <a class="btn btn-default btn-xs" id="btInserir"  data-toggle="modal" data-target="#myModalTratRet">
            <i class="fa fa-plus-square"> Inserir</i>
        </a>
        @include('admin.canal.tratret.create')
        <a class="btn btn-default btn-xs disabled"   data-toggle="modal" data-target="#myModalTratRetEdita" id="btEditar">
            <i class="fa fa-pencil-square-o"> Editar</i>
        </a>
        @include('admin.canal.tratret.edit')
        <a class="btn btn-default btn-xs disabled" id="btDeletar">
            <i class="fa fa-trash"> Deletar</i>
        </a>
    </div>
    <div class="x_content">

        <table id="tbTratRet" class="table table-hover table-bordered table-striped datatable display responsive nowrap" style="width:100%">
            <thead>
            <tr>
                <th>Descrição</th>
                <th>Evento</th>
                <th>Número Erro</th>
            </tr>
            </thead>
        </table>
    </div>
</div>

@push('scripts')
    @include('admin.canal.tratret.js.script');
@endpush