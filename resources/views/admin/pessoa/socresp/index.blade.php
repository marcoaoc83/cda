<div class="x_panel" id="pnSocResp">
    <div class="x_title">
        <h2>Sócios e/ou Responsáveis<small></small></h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>

    <div class="x_content">
        <table id="tbSocResp" class="table table-hover table-bordered table-striped datatable display responsive nowrap" style="width:100%">
            <thead>
            <tr>
                <th>CPF / CNPJ</th>
                <th>Nome</th>
                <th>Inicio</th>
                <th>Termino</th>
            </tr>
            </thead>
        </table>
    </div>
</div>
@push('scripts')
    @include('admin.pessoa.socresp.js.script');
@endpush
