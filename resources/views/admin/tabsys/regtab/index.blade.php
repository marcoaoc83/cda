<div class="x_panel">
    <div class="x_content x_title profile_title">
        <a class="btn btn-default btn-xs" id="btInserir"  data-toggle="modal" data-target="#myModal">
            <i class="fa fa-plus-square"> Inserir</i>
        </a>
        @include('admin.tabsys.regtab.insere')
        <a class="btn btn-default btn-xs disabled"   data-toggle="modal" data-target="#modalEdita" id="btEditar">
            <i class="fa fa-pencil-square-o"> Editar</i>
        </a>
        @include('admin.tabsys.regtab.edita')
        <a class="btn btn-default btn-xs disabled" id="btDeletar">
            <i class="fa fa-trash"> Deletar</i>
        </a>
    </div>
    <div class="x_content">

        <table class="table table-hover table-bordered table-striped datatable display responsive nowrap" style="width:100%">
            <thead>
            <tr>
                <th>ID</th>
                <th>Sigla Única</th>
                <th>Sigla Usuário</th>
                <th>Nome</th>
                <th>SQL</th>
            </tr>
            </thead>
        </table>
    </div>
</div>