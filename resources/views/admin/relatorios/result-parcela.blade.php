<div class="x_panel" id="divResultParcela" style="display: ">
    <div class="x_title">
        <h2>Parcelas<small></small></h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <table id="tbParcela" class="table table-hover table-bordered table-striped datatable display responsive nowrap" style="width:100%">
            <thead>
            <tr>
                
                <th>Carteira</th>
                <th>Modelo</th>
                <th>Nome</th>
                <th>CPF/CNPJ</th>
                <th>{{App\Models\RegTab::where('REGTABSG','AbDocument')->first()->REGTABNM}}</th>
                <th>Sit Pag</th>
                <th>Sit Cob</th>
                <th>Orig Trib</th>
                <th>Trib</th>
                <th>Lcto</th>
                <th>Pc</th>
                <th>Pl</th>
                <th>Vencimento</th>
                <th class="text-right">Valor</th>
                {{--<th>Fx Atraso</th>--}}
                {{--<th>Fx Valor</th>--}}
            </tr>
            </thead>
        </table>
    </div>
</div>