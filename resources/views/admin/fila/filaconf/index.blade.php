<div class="col-md-8 col-sm-8 col-xs-12 " >
<div class="x_panel" id="pnFilaConf">
    <div class="x_title">
        <h2>Configurações de Fila <small></small></h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content x_title profile_title">
        <a class="btn btn-default btn-xs" id="btInserir"  data-toggle="modal" data-target="#myModalFilaConf">
            <i class="fa fa-plus-square"> Inserir</i>
        </a>
        @include('admin.fila.filaconf.create')
        <a class="btn btn-default btn-xs disabled"   data-toggle="modal" data-target="#myModalFilaConfEdita" id="btEditar">
            <i class="fa fa-pencil-square-o"> Editar</i>
        </a>
        @include('admin.fila.filaconf.edit')
        <a class="btn btn-default btn-xs disabled" id="btDeletar">
            <i class="fa fa-trash"> Deletar</i>
        </a>
    </div>
    <div class="x_content">

        <table id="tbFilaConf" class="table table-hover table-bordered table-striped datatable display responsive nowrap" style="width:100%">
            <thead>
            <tr>
                <th>Tab Tab</th>
                <th>Variável</th>
                <th>Descrição</th>
            </tr>
            </thead>
        </table>
    </div>
</div>
</div>
@push('scripts')
    @include('admin.fila.filaconf.js.script');
@endpush
