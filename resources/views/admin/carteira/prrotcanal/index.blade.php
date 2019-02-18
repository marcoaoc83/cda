<div class="x_panel" id="pnPrRotCanal">
    <div class="x_title">
        <h2>Prioridades do Canal<small>(Selecione um roteiro)</small></h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content x_title profile_title">
        <a class="btn btn-default btn-xs disabled" id="btInserir"  data-toggle="modal" data-target="#myModalPrRotCanal">
            <i class="fa fa-plus-square"> Inserir</i>
        </a>
        @include('admin.carteira.prrotcanal.create')
        <a class="btn btn-default btn-xs disabled"   data-toggle="modal" data-target="#myModalPrRotCanalEdita" id="btEditar">
            <i class="fa fa-pencil-square-o"> Editar</i>
        </a>
        @include('admin.carteira.prrotcanal.edit')
        <a class="btn btn-default btn-xs disabled" id="btDeletar">
            <i class="fa fa-trash"> Deletar</i>
        </a>
    </div>
    <div class="x_content">

        <table id="tbPrRotCanal" class="table table-hover table-bordered table-striped datatable display responsive nowrap" style="width:100%">
            <thead>
            <tr>
                <th>Pr</th>
                <th>Tipos Possíveis Canal</th>
            </tr>
            </thead>
        </table>
    </div>
</div>
@push('scripts')
    @include('admin.carteira.prrotcanal.js.script');
@endpush
