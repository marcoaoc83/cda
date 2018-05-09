<div class="x_panel" id="pnPcRot">
    <div class="x_title">
        <h2>E/S da Parcela no Roteiro<small></small></h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>

    <div class="x_content">
        <table id="tbPcRot" class="table table-hover table-bordered table-striped datatable display responsive nowrap" style="width:100%">
            <thead>
            <tr>
                <th>Carteira</th>
                <th>Ord</th>
                <th>Fase Cart</th>
                <th>Evento</th>
                <th>Entrada</th>
                <th>Saída</th>
            </tr>
            </thead>
        </table>
    </div>
</div>
@push('scripts')
    @include('admin.pessoa.pcrot.js.script');
@endpush
