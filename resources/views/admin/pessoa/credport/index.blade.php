<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
<div class="x_panel" id="pnCredPort">
    <div class="x_title">
        <h2>Credenciais no Portal<small></small></h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content x_title profile_title">
        <a class="btn btn-default btn-xs " id="btInserir"  data-toggle="modal" data-target="#myModalCredPort">
            <i class="fa fa-plus-square"> Inserir</i>
        </a>
        @include('admin.pessoa.credport.create')
        <a class="btn btn-default btn-xs disabled"   data-toggle="modal" data-target="#myModalCredPortEdita" id="btEditar">
            <i class="fa fa-pencil-square-o"> Editar</i>
        </a>
        @include('admin.pessoa.credport.edit')
        <a class="btn btn-default btn-xs disabled" id="btDeletar">
            <i class="fa fa-trash"> Deletar</i>
        </a>
    </div>
    <div class="x_content">
        <table id="tbCredPort" class="table table-hover table-bordered table-striped datatable display responsive nowrap" style="width:100%">
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
    @include('admin.pessoa.credport.js.script');
@endpush
