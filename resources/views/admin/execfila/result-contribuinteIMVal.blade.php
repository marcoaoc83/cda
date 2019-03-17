<div class="x_panel" id="divResultContribuinteResIMVal" style="display: none">
    <div class="x_title">
        <h2>{{App\Models\RegTab::where('REGTABSG','LbDocument')->first()->REGTABNM}}<small></small></h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <table id="tbContribuinteResIMVal" class="table table-hover table-bordered table-striped datatable display responsive nowrap" style="width:100%">
            <thead>
            <tr>
                <th>Número {{App\Models\RegTab::where('REGTABSG','AbDocument')->first()->REGTABNM}}</th>
            </tr>
            </thead>
        </table>
    </div>
</div>