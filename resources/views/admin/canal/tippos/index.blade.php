<div class="x_panel" id="pnTipPos">
    <div class="x_title">
        <h2>Tipos Possíveis <small></small></h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content x_title profile_title">
        <a class="btn btn-default btn-xs" id="btInserir"  data-toggle="modal" data-target="#myModalTipPos">
            <i class="fa fa-plus-square"> Inserir</i>
        </a>
        @include('admin.canal.tippos.create')
        <a class="btn btn-default btn-xs disabled"   data-toggle="modal" data-target="#myModalTipPosEdita" id="btEditar">
            <i class="fa fa-pencil-square-o"> Editar</i>
        </a>
        @include('admin.canal.tippos.edit')
        <a class="btn btn-default btn-xs disabled" id="btDeletar">
            <i class="fa fa-trash"> Deletar</i>
        </a>
    </div>
    <div class="x_content">

        <table id="tbTipPos" class="table table-hover table-bordered table-striped datatable display responsive nowrap" style="width:100%">
            <thead>
            <tr>
                <th>Sigla</th>
                <th>Descrição</th>
            </tr>
            </thead>
        </table>
    </div>
</div>

@push('scripts')
    @include('admin.canal.tippos.js.script');
@endpush