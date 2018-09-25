<div class="x_panel" id="pnRegraTributo">
    <div class="x_title">
        <h2>Tributos<small></small></h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content x_title profile_title">
        <a class="btn btn-default btn-xs" id="btInserir"  data-toggle="modal" data-target="#myModalRegraTributo">
            <i class="fa fa-plus-square"> Inserir</i>
        </a>
        @include('admin.regra.regtributo.create')
        <a class="btn btn-default btn-xs disabled" id="btDeletar">
            <i class="fa fa-trash"> Deletar</i>
        </a>
    </div>
    <div class="x_content">

        <table id="tbRegraTributo" class="table table-hover table-bordered table-striped datatable display responsive nowrap" style="width:100%">
            <thead>
            <tr>
                <th>Tributo</th>
            </tr>
            </thead>
        </table>
    </div>
</div>
@push('scripts')
    @include('admin.regra.regtributo.js.script');
@endpush
