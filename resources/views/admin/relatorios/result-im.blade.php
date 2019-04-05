<div class="x_panel " id="divResultIM" style="display: none">
    <div class="x_title">
        <h2>{{App\Models\RegTab::where('REGTABSG','LbDocument')->first()->REGTABNM}}<small></small></h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <table id="tbIMRes" class="table table-hover table-bordered table-striped datatable display responsive nowrap" style="width:100%">
            <thead>
            <tr>
                <th>Nome</th>
                <th>{{App\Models\RegTab::where('REGTABSG','GdDocument')->first()->REGTABNM}}</th>
                <th>Vencimento</th>
                <th style="text-align: right">Valor</th>
                <th>Fx Atraso</th>
                <th>Fx Valor</th>
            </tr>
            </thead>
        </table>
    </div>
</div>