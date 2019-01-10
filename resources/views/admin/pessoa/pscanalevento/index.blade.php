<div class="x_panel" id="pnPsCanalEvento">
    <div class="x_title">
        <h2>Eventos do Canal<small></small></h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>

    <div class="x_content">
        <table id="tbPsCanalEvento" class="table table-hover table-bordered table-striped datatable display responsive nowrap" style="width:100%">
            <thead>
            <tr>
                <th>Data</th>
                <th>Objetivo</th>
                <th>Ação</th>
                <th>Fila</th>
                <th>Fonte</th>
                <th>Canal</th>
                <th>Tipo</th>
            </tr>
            </thead>
        </table>
    </div>
</div>
@push('scripts')
    @include('admin.pessoa.pscanalevento.js.script');
@endpush
