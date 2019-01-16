<div class="x_panel" id="pnParcela">
    <div class="x_title">
        <h2>Parcelas<small> *(Para inserir, selecione uma I.M.)</small></h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content x_title profile_title">
        <a class="btn btn-default btn-xs" id="btInserir"  data-toggle="modal" data-target="#myModalParcela">
            <i class="fa fa-plus-square"> Inserir</i>
        </a>
        @include('admin.pessoa.parcela.create')
        <a class="btn btn-default btn-xs disabled"   data-toggle="modal" data-target="#myModalParcelaEdita" id="btEditar">
            <i class="fa fa-pencil-square-o"> Editar</i>
        </a>
        @include('admin.pessoa.parcela.edit')
        <a class="btn btn-default btn-xs disabled" id="btDeletar">
            <i class="fa fa-trash"> Deletar</i>
        </a>
    </div>
    <div class="x_content">
        <table id="tbParcela" class="table table-hover table-bordered table-striped datatable display responsive nowrap" style="width:100%;font-size:11px">
            <thead>
            <tr>
                <th>Sit Pag</th>
                <th>Sit Cob</th>
                <th>Orig Trib</th>
                <th>Tributo</th>
                <th>Lcto</th>
                <th>Pc</th>
                <th>Pl</th>
                <th>Vencimento</th>
                <th>Principal</th>
                <th>Multa</th>
                <th>Juros</th>
                <th>Taxa</th>
                <th>Acrescimo</th>
                <th>Desconto</th>
                <th>Honorarios</th>
                <th>Total</th>
            </tr>
            </thead>
        </table>
    </div>
</div>
@push('scripts')
    @include('admin.pessoa.parcela.js.script');
@endpush
