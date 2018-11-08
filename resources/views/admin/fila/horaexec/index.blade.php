
<div class="col-md-4 col-sm-4 col-xs-12 "  >
    <div class="x_panel" id="pnHoraExec">
    <div class="x_title">
        <h2>Horários de Execução <small></small></h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content x_title profile_title">
        <a class="btn btn-default btn-xs" id="btInserir"  data-toggle="modal" data-target="#myModalHoraExec">
            <i class="fa fa-plus-square"> Inserir</i>
        </a>
        @include('admin.fila.horaexec.create')
        <a class="btn btn-default btn-xs disabled"   data-toggle="modal" data-target="#myModalHoraExecEdita" id="btEditar">
            <i class="fa fa-pencil-square-o"> Editar</i>
        </a>
        @include('admin.fila.horaexec.edit')
        <a class="btn btn-default btn-xs disabled" id="btDeletar">
            <i class="fa fa-trash"> Deletar</i>
        </a>
    </div>
    <div class="x_content">

        <table id="tbHoraExec" class="table table-hover table-bordered table-striped datatable display responsive nowrap" style="width:100%">
            <thead>
            <tr>
                <th>Dia</th>
                <th>Hora Inicial</th>
                <th>Hora Final</th>
            </tr>
            </thead>
        </table>
    </div>
</div>
</div>
@push('scripts')
    @include('admin.fila.horaexec.js.script');
@endpush
