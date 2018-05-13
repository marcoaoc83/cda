<div class="x_panel" id="pnAtiveCom">
    <div class="x_title">
        <h2>Atividade Econômica<small></small></h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content x_title profile_title">
        <a class="btn btn-default btn-xs disabled" id="btInserir"  data-toggle="modal" data-target="#myModalAtiveCom">
            <i class="fa fa-plus-square"> Inserir</i>
        </a>
        @include('admin.pessoa.ativecon.create')
        <a class="btn btn-default btn-xs disabled"   data-toggle="modal" data-target="#myModalAtiveComEdita" id="btEditar">
            <i class="fa fa-pencil-square-o"> Editar</i>
        </a>
        @include('admin.pessoa.ativecon.edit')
        <a class="btn btn-default btn-xs disabled" id="btDeletar">
            <i class="fa fa-trash"> Deletar</i>
        </a>
    </div>
    <div class="x_content">
        <table id="tbAtiveCom" class="table table-hover table-bordered table-striped datatable display responsive nowrap" style="width:100%">
            <thead>
            <tr>
                <th>Cnae Cbo</th>
                <th>Inicio</th>
                <th>Termino</th>
            </tr>
            </thead>
        </table>
    </div>
</div>
@push('scripts')
    @include('admin.pessoa.ativecon.js.script');
@endpush
