<div class="x_panel" id="pnPsCanal">
    <div class="x_title">
        <h2>Canais de Comunicação<small></small></h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>

    <div class="x_content">
        <table id="tbPsCanal" class="table table-hover table-bordered table-striped datatable display responsive nowrap" style="width:100%">
            <thead>
            <tr>
                <th>Fonte</th>
                <th>Canal</th>
                <th>Tip Pos</th>
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
