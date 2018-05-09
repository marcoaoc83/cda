<div class="x_panel" id="pnAtivCom">
    <div class="x_title">
        <h2>Atividade Econômica<small></small></h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>

    <div class="x_content">
        <table id="tbAtivCom" class="table table-hover table-bordered table-striped datatable display responsive nowrap" style="width:100%">
            <thead>
            <tr>
                <th>Cnae Cbo</th>
                <th>Inicio</th>
                <th>Termino</th>
            </tr>
            </thead>
        </table>
    </div>
</div>
@push('scripts')
    @include('admin.pessoa.ativecon.js.script');
@endpush
