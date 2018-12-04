<div class="x_panel" id="pnEvento">
    <div class="x_title">
        <h2>Eventos Possíveis<small></small></h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content x_title profile_title">
        <a class="btn btn-default btn-xs" id="btInserir"  data-toggle="modal" data-target="#myModalEvento">
            <i class="fa fa-plus-square"> Inserir</i>
        </a>
        @include('admin.canal.eventos.create')
        <a class="btn btn-default btn-xs disabled" id="btDeletar">
            <i class="fa fa-trash">Deletar</i>
        </a>
    </div>
    <div class="x_content">

        <table id="tbEvento" class="table table-hover table-bordered table-striped datatable display responsive nowrap" style="width:100%">
            <thead>
            <tr>
                <th>Evento</th>
            </tr>
            </thead>
        </table>
    </div>
</div>

@push('scripts')
    @include('admin.canal.eventos.js.script')
@endpush