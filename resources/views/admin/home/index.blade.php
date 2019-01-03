@extends('layouts.app')
@section('styles')
    <link href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css" rel="stylesheet">
@endsection
@section('content')
    <!-- page content -->
    <form id="formFiltro">
        <div class="right_col" role="main">
            <div class="row top_tiles" style="margin: 10px 0;">
                <div class="col-md-9">
                    <div class=" text-center">
                        <section class="panel">
                            <div class="x_title" style="background-color:#34495E">
                                <h3>Acionamentos</h3>
                                <div class="clearfix"></div>
                            </div>
                            <div id="area-chart" ></div>
                        </section>
                    </div>
                    <div class="col-md-4 text-center">
                        <section class="panel">
                            <div class="x_title" style="background-color:#34495E">
                                <h3>Origem</h3>
                                <div class="clearfix"></div>
                            </div>
                            <div id="pie-chart-origem" ></div>
                        </section>
                    </div>
                    <div class="col-md-4 text-center">
                        <section class="panel">
                            <div class="x_title" style="background-color:#34495E">
                                <h3>Carteira</h3>
                                <div class="clearfix"></div>
                            </div>
                            <div id="pie-chart-carteira" ></div>
                        </section>
                    </div>
                    <div class="col-md-4 text-center">
                        <section class="panel">
                            <div class="x_title" style="background-color:#34495E">
                                <h3>Fase</h3>
                                <div class="clearfix"></div>
                            </div>
                            <div id="pie-chart-fase" ></div>
                        </section>
                    </div>
                    <div class="col-md-12 text-center">
                        <section class="panel">
                            <div class="x_title" style="background-color:#34495E">
                                <h3>Faixa Atraso</h3>
                                <div class="clearfix"></div>
                            </div>
                            <div id="bar-chart" ></div>
                        </section>
                    </div>
                </div>
                <div class="col-md-3">
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
                                <button type="button" class="btn btn-default btn-xs  filt" id="origemIMOB" value="IMOB" >IMOB</button>
                                <button type="button" class="btn btn-default btn-xs  filt" id="origemIMOB" value="MOB" >MOB</button>
                                <button type="button" class="btn btn-default btn-xs  filt" id="origemIMOB" value="PESSOA" >PESSOA</button>
                            </div>
                            <div class="x_content" style="background-color: #dfeef0">
                                <h5>Carteira</h5>
                                <button type="button" class="btn btn-default btn-xs filt">Ano</button>
                                <button type="button" class="btn btn-default btn-xs filt">DAT</button>
                                <button type="button" class="btn btn-default btn-xs filt">NLD</button>
                                <button type="button" class="btn btn-default btn-xs filt">PC</button>
                                <button type="button" class="btn btn-default btn-xs filt">PPI</button>
                                <button type="button" class="btn btn-default btn-xs filt">PPI E PC</button>
                                <button type="button" class="btn btn-default btn-xs filt">REFIS</button>
                            </div>
                            <div class="x_content" style="background-color: #dfeef0">
                                <h5>Fase</h5>
                                <button type="button" class="btn btn-default btn-xs filt">Cob Adm</button>
                                <button type="button" class="btn btn-default btn-xs filt">Exec Fisc</button>
                                <button type="button" class="btn btn-default btn-xs filt">Hig Cad</button>
                                <button type="button" class="btn btn-default btn-xs filt">Prot Tit</button>
                                <button type="button" class="btn btn-default btn-xs filt">Ret Com</button>
                            </div>
                            <div class="x_content" style="background-color: #dfeef0">
                                <h5>Faixa Atraso</h5>
                                @foreach ($FxAtraso as  $value)
                                    <button type="button" class="btn btn-default btn-xs filt">{{$value->REGTABSG}}</button>
                                @endforeach
                            </div>
                            <div class="x_content" style="background-color: #dfeef0">
                                <h5>Ano</h5>
                                @for($x=2013;$x<=date('Y');$x++)
                                    <button type="button" class="btn btn-default btn-xs filt">{{$x}}</button>
                                @endfor
                            </div>
                            <div class="x_content" style="background-color: #dfeef0">
                                <h5>Mês</h5>
                                <button type="button" class="btn btn-default btn-xs filt">Jan</button>
                                <button type="button" class="btn btn-default btn-xs filt">Fev</button>
                                <button type="button" class="btn btn-default btn-xs filt">Mar</button>
                                <button type="button" class="btn btn-default btn-xs filt">Abr</button>
                                <button type="button" class="btn btn-default btn-xs filt">Mai</button>
                                <button type="button" class="btn btn-default btn-xs filt">Jun</button>
                                <button type="button" class="btn btn-default btn-xs filt">Jul</button>
                                <button type="button" class="btn btn-default btn-xs filt">Ago</button>
                                <button type="button" class="btn btn-default btn-xs filt">Set</button>
                                <button type="button" class="btn btn-default btn-xs filt">Out</button>
                                <button type="button" class="btn btn-default btn-xs filt">Nov</button>
                                <button type="button" class="btn btn-default btn-xs filt">Dez</button>

                            </div>
                            <div class="x_content text-center">
                                <button type="button" class="btn btn-success btn-sm">Filtrar</button>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </form>
    <!-- /page content -->
@endsection
@push('scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <script>
        var data = [
                { y: '2011', a: 400000 },
                { y: '2012', a: 670000 },
                { y: '2013', a: 450000 },
                { y: '2014', a: 500000 },
                { y: '2015', a: 650000 },
                { y: '2016', a: 500000 },
                { y: '2017', a: 750000 },
                { y: '2018', a: 800000 },
            ],
            config = {
                data: data,
                xkey: 'y',
                ykeys: ['a'],
                labels: ['Total'],
                fillOpacity: 0.6,
                hideHover: 'auto',
                behaveLikeLine: true,
                resize: true,
                pointFillColors:['#ffffff'],
                pointStrokeColors: ['black'],
                lineColors:['#26B99A' ]
            };
        config.element = 'area-chart';
        Morris.Area(config);

        Morris.Donut({
            element: 'pie-chart-origem',
            data: [
                {label: "Pessoa", value: 17000},
                {label: "Mobiliario", value: 197000},
                {label: "Imobiliario", value: 414000}
            ],
            colors:["#172D44","#26B99A","#8BE1CF"]
        });
        Morris.Donut({
            element: 'pie-chart-carteira',
            data: [
                {label: "DAT", value: 68.56},
                {label: "PPI", value: 2},
                {label: "Ano", value: 12.88},
                {label: "NLD", value: 4.26},
                {label: "PC", value: 3.7},
                {label: "REFIS", value: 5.56},
            ],
            colors:["#172D44","#26B99A","#8BE1CF","RED","YELLOW","GRAY"],
            formatter:function (y, data) { return y + '%'}
        });
        Morris.Donut({
            element: 'pie-chart-fase',
            data: [
                {label: "Cob Adm", value: 68.56},
                {label: "Exec Fisc", value: 2},
                {label: "Hig Cad", value: 8.88},
                {label: "Prot Tit", value: 12.26},
                {label: "Ret Com", value: 3.7},
            ],
            colors:["#26B99A","#172D44","#8BE1CF","RED","YELLOW","GRAY"],
            formatter:function (y, data) { return y + '%'}
        });

        var data = [
                { y: '0..1m', a: 400000 },
                { y: '1..3m', a: 670000 },
                { y: '3..6m', a: 450000 },
                { y: '6..12m', a: 500000 },
                { y: '1..2a', a: 650000 },
                { y: '2..3a', a: 500000 },
                { y: '3..4a', a: 750000 },
                { y: '4..5a', a: 800000 },
                { y: '5a..', a:  900000  },
            ],
            config = {
                data: data,
                xkey: 'y',
                ykeys: ['a'],
                labels: ['Total'],
                fillOpacity: 0.6,
                hideHover: 'auto',
                behaveLikeLine: true,
                resize: true,
                pointFillColors:['#ffffff'],
                pointStrokeColors: ['black'],
                barColors:['#26B99A' ]
            };
        config.element = 'bar-chart';
        Morris.Bar(config);

        $( ".filt" ).click(function() {

            $(this).button('toggle');
            $(this).button('dispose');
        });
    </script>
@endpush