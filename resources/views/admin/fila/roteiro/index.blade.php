<div class="col-md-8 col-sm-8 col-xs-12 "   >
<div class="x_panel" id="pnRoteiro">
    <div class="x_title">
        <h2>Roteiro<small></small></h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <table id="tbRoteiro" class="table table-hover table-bordered table-striped datatable display responsive nowrap" style="width:100%">
            <thead>
            <tr>
                <th>Ord</th>
                <th>FaseCart</th>
                <th>Evento</th>
                <th>Modelo</th>
                <th>Fila</th>
                <th>Canal</th>
                <th>Prox Roteiro</th>
            </tr>
            </thead>
        </table>
    </div>
</div>
</div>
@push('scripts')
    @include('admin.fila.roteiro.js.script');
@endpush
