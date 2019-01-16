<div class="x_panel" id="pnPsCanal">
    <div class="x_title">
        <h2>Canais de Comunicação<small> *(Para inserir, selecione uma I.M.)</small></h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content x_title profile_title">
        <a class="btn btn-default btn-xs " id="btInserir"  data-toggle="modal" data-target="#myModalPsCanal">
            <i class="fa fa-plus-square"> Inserir</i>
        </a>
        @include('admin.pessoa.pscanal.create')
        <a class="btn btn-default btn-xs disabled"   data-toggle="modal" data-target="#myModalPsCanalEdita" id="btEditar">
            <i class="fa fa-pencil-square-o"> Editar</i>
        </a>
        @include('admin.pessoa.pscanal.edit')
        <a class="btn btn-default btn-xs disabled" id="btDeletar">
            <i class="fa fa-trash"> Deletar</i>
        </a>
    </div>
    <div class="x_content">
        <table id="tbPsCanal" class="table table-hover table-bordered table-striped datatable display responsive nowrap" style="width:100%">
            <thead>
            <tr>
                <th>Fonte</th>
                <th>Canal</th>
                <th>Tipo Pos</th>
                <th>Telefone</th>
                <th>Email</th>
                <th>CEP</th>
                <th>Logradouro</th>
                <th>Nr</th>
                <th>Complemento</th>
                <th>Bairro</th>
                <th>Cidade</th>
                <th>UF</th>
            </tr>
            </thead>
        </table>
    </div>
</div>
@push('scripts')
    @include('admin.pessoa.pscanal.js.script');
@endpush
