<div class="col-md-3">
    <div class="x_panel">
        <div class="x_title">
            <h2>Dashboard </h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content" style="background-color: #dfeef0; text-align: center;">
            <p></p>
            <select id="selDash" style="font-size: 18px;width: 100%">
                <option value="1">Acionamentos</option>
                <option value="2">Parcelas</option>
            </select>
        </div>
    </div>
    <div class="x_panel">
        <div class="x_title">
            <h2>Filtros</h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content" style="background-color: #dfeef0">
            <h5>Origem</h5>
            @foreach ($Origem as  $value)
                <button type="button" class="btn btn-default btn-xs filt" data-nome="OrigemTrib" value="{{$value->REGTABID}}">{{$value->REGTABSG}}</button>
            @endforeach
        </div>
        <div class="x_content" style="background-color: #dfeef0">
            <h5>Carteira</h5>
            @foreach ($Carteira as  $value)
                <button type="button" class="btn btn-default btn-xs filt" data-nome="Carteira" value="{{$value->CARTEIRAID}}">{{$value->CARTEIRASG}}</button>
            @endforeach
        </div>
        <div class="x_content" style="background-color: #dfeef0">
            <h5>Fase</h5>
            @foreach ($Fase as  $value)
                <button type="button" class="btn btn-default btn-xs filt" data-nome="Fase" value="{{$value->REGTABID}}">{{$value->REGTABSG}}</button>
            @endforeach
        </div>
        <div class="x_content" style="background-color: #dfeef0">
            <h5>Faixa Atraso</h5>
            @foreach ($FxAtraso as  $value)
                <button type="button" class="btn btn-default btn-xs filt" data-nome="FxAtraso" value="{{$value->REGTABID}}">{{$value->REGTABSG}}</button>
            @endforeach
        </div>
        <div class="x_content" style="background-color: #dfeef0">
            <h5>Ano</h5>
            @for($x=2013;$x<=date('Y');$x++)
                <button type="button" class="btn btn-default btn-xs filt" data-nome="Ano" value="{{$x}}">{{$x}}</button>
            @endfor
        </div>
        <div class="x_content" style="background-color: #dfeef0">
            <h5>Mês</h5>
            <button type="button" class="btn btn-default btn-xs filt" data-nome="Mes" value="1">Jan</button>
            <button type="button" class="btn btn-default btn-xs filt" data-nome="Mes" value="2">Fev</button>
            <button type="button" class="btn btn-default btn-xs filt" data-nome="Mes" value="3">Mar</button>
            <button type="button" class="btn btn-default btn-xs filt" data-nome="Mes" value="4">Abr</button>
            <button type="button" class="btn btn-default btn-xs filt" data-nome="Mes" value="5">Mai</button>
            <button type="button" class="btn btn-default btn-xs filt" data-nome="Mes" value="6">Jun</button>
            <button type="button" class="btn btn-default btn-xs filt" data-nome="Mes" value="7">Jul</button>
            <button type="button" class="btn btn-default btn-xs filt" data-nome="Mes" value="8">Ago</button>
            <button type="button" class="btn btn-default btn-xs filt" data-nome="Mes" value="9">Set</button>
            <button type="button" class="btn btn-default btn-xs filt" data-nome="Mes" value="10">Out</button>
            <button type="button" class="btn btn-default btn-xs filt" data-nome="Mes" value="11">Nov</button>
            <button type="button" class="btn btn-default btn-xs filt" data-nome="Mes" value="12">Dez</button>

        </div>
        <div class="x_content text-center">
            <button type="button" class="btn btn-success btn-sm" id="filtrarGrafico">Filtrar</button>
        </div>
    </div>
</div>