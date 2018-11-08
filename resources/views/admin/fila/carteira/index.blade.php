<div class="col-md-4 col-sm-4 col-xs-12 "  >
<div class="x_panel" id="pnCarteira">
    <div class="x_title">
        <h2>Carteira<small></small></h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <table id="tbCarteira" class="table table-hover table-bordered table-striped datatable display responsive nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>Ordem</th>
                    <th>Sigla</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
</div>
@push('scripts')
    @include('admin.fila.carteira.js.script');
@endpush
