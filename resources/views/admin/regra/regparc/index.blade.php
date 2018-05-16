<div class="x_panel" id="pnRegParc">
    <div class="x_title">
        <h2>Regras de Parcelamento<small></small></h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content x_title profile_title">
        <a class="btn btn-default btn-xs" id="btInserir"  data-toggle="modal" data-target="#myModalRegParc">
            <i class="fa fa-plus-square"> Inserir</i>
        </a>
        @include('admin.regra.regparc.create')
        <a class="btn btn-default btn-xs disabled"   data-toggle="modal" data-target="#myModalRegParcEdita" id="btEditar">
            <i class="fa fa-pencil-square-o"> Editar</i>
        </a>
        @include('admin.regra.regparc.edit')
        <a class="btn btn-default btn-xs disabled" id="btDeletar">
            <i class="fa fa-trash"> Deletar</i>
        </a>
    </div>
    <div class="x_content">

        <table id="tbRegParc" class="table table-hover table-bordered table-striped datatable display responsive nowrap" style="width:100%">
            <thead>
            <tr>
                <th>PcQt</th>
                <th>TpOp</th>
                <th>Fator</th>
                <th>% Desc Juros</th>
                <th>% Desc Multa</th>
                <th>% Desc Principal</th>
                <th>Vr Min Entrada</th>
                <th>Vr Min Parcela</th>
            </tr>
            </thead>
        </table>
    </div>
</div>
@push('scripts')
    @include('admin.regra.regparc.js.script');
@endpush
