<div class="x_panel" id="pnValEnv">
    <div class="x_title">
        <h2>Validação de Envio <small></small></h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content x_title profile_title">
        <a class="btn btn-default btn-xs" id="btInserir"  data-toggle="modal" data-target="#myModalValEnv">
            <i class="fa fa-plus-square"> Inserir</i>
        </a>
        @include('admin.canal.valenv.create')
        <a class="btn btn-default btn-xs disabled"   data-toggle="modal" data-target="#myModalValEnvEdita" id="btEditar">
            <i class="fa fa-pencil-square-o"> Editar</i>
        </a>
        @include('admin.canal.valenv.edit')
        <a class="btn btn-default btn-xs disabled" id="btDeletar">
            <i class="fa fa-trash"> Deletar</i>
        </a>
    </div>
    <div class="x_content">

        <table id="tbValEnv" class="table table-hover table-bordered table-striped datatable display responsive nowrap" style="width:100%">
            <thead>
            <tr>
                <th>Sigla</th>
                <th>Nome</th>
                <th>Evento</th>
            </tr>
            </thead>
        </table>
    </div>
</div>

@push('scripts')
    @include('admin.canal.valenv.js.script');
@endpush