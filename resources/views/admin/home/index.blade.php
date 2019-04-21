@extends('layouts.app')
@section('styles')
    <link href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css" rel="stylesheet">
@endsection
@section('content')
    <!-- page content -->
    <form id="formFiltro">
        {{ csrf_field() }}
        <div class="right_col" role="main">
            <div class="row top_tiles" style="margin: 10px 0;">
                <div class="col-md-12" id="graficosHome">

                </div>
            </div>
        </div>
    </form>
    <!-- /page content -->
@endsection
@push('scripts')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>
    <script src="http://code.highcharts.com/modules/exporting.js"></script>
    <script>
        Highcharts.setOptions({
            lang: {
                contextButtonTitle: 'Opções Avançadas',
                decimalPoint: ',',
                downloadJPEG: 'Salvar como JPEG',
                downloadPDF: 'Salvar como PDF',
                downloadPNG: 'Salvar como PNG',
                downloadSVG: 'Salvar como SVG',
                drillUpText: '<< Voltar ',
                loading: 'Aguarde...',

                noData: 'Sem dados a exibir para este gráfico!',
                printChart: 'Imprimir',
                resetZoom: 'Desfazer zoom',
                resetZoomTitle: 'Voltar zoom 1:1',
                thousandsSep: '.'
            }
        });

        $.ajax({
            type: 'POST',
            dataType: 'json',
            data: {
                _token: '{!! csrf_token() !!}',
            },
            url: '{{ route('graficos.home') }}',
            success: function(datas){
                $.each(datas, function(index1) {

                    var series='';
                    var titulo='';
                    var nome='';
                    var pai='';
                    var ref='';
                    var axes=[];
                    var yAxisC=1;
                    var yAxis=[];
                    $.each(datas[index1], function(index) {
                        let data = datas[index1];
                        var new_data = [];
                        $("#graficosHome").append('<br><div class=" text-center"><div id="container'+index+'" style="min-width: 310px; height: 400px; margin: 0 auto"></div></div>');

                        series=data[index].series.data;
                        nome=data[index].series.name;
                        titulo=data[index].titulo;
                        pai=data[index].pai;
                        ref=data[index].ref;
                        $.each(series, function(index2) {
                            new_data.push({
                                name:series[index2].name,
                                y:parseInt(series[index2].y)
                            });
                        });
                        if(index+1==datas[index1].length){
                            axes.push({
                                name:nome,
                                type:data[index].tipo,
                                data:new_data
                            });
                        }else{
                            axes.push({
                                name:nome,
                                yAxis: yAxisC,
                                type:data[index].tipo,
                                data:new_data
                            });
                        }
                        yAxisC++;
                        yAxis.push({
                            labels:false,
                            title: false
                        });
                    });

                    // Create the chart
                    var chart= Highcharts.chart('container'+index1, {
                        chart: {
                            backgroundColor: '#c2e0e1',

                            events: {
                                // drilldown: function(e) {
                                //     chart.setTitle({ text: e.point.name });
                                // },
                                // drillup: function(e) {
                                //     chart.setTitle({ text: data[index].titulo });
                                // }
                            },
                        },
                        title: {
                            text:  titulo
                        },
                        xAxis: {
                            type: 'category'
                        },
                        yAxis: yAxis,
                        legend: {
                            enabled: false
                        },

                        plotOptions: {
                            series: {
                                borderWidth: 0,
                                dataLabels: {
                                    enabled: true
                                },
                                colorByPoint: true,
                                cursor: 'pointer',
                                point: {
                                    events: {
                                        click: function() {
                                            console.log(ref);
                                            if (ref > 0)
                                                mostraGrafico("container"+index1,ref,event.point.name,pai);
                                        }
                                    }
                                }
                            }
                        },
                        series:axes,
                    });
                });
            }
        });

        function mostraGrafico(elemento,id,filtro,pai,filtros) {
            if (typeof filtros === "undefined") {
                var filtros = [];
            }
            if($.isArray(filtro)){

                $.merge(filtros,filtro);
            }else{
                filtros.push(filtro);
            }

            $.ajax({
                type: 'POST',
                dataType: 'json',
                data: {
                    _token: '{!! csrf_token() !!}',
                    id:id,
                    filtros:filtros
                },
                url: '{{ route('graficos.home') }}',
                success: function(datas){
                    $.each(datas, function(index1) {

                        var series='';
                        var titulo='';
                        var nome='';
                        var vpai='';
                        var vref='';
                        var axes=[];
                        var yAxisC=1;
                        var yAxis=[];
                        var textoVoltar='';
                        $.each(datas[index1], function(index) {
                            let data = datas[index1];
                            $(elemento).html(' ');
                            series=data[index].series.data;
                            nome=data[index].series.name;

                            vpai=data[index].pai;
                            vref=data[index].ref;
                            var new_data = [];
                            if(filtros.length>0) {
                                textoVoltar='<< Voltar';
                                titulo=data[index].titulo+" - "+filtro;
                            }else{
                                textoVoltar='';
                                titulo=data[index].titulo;
                            }
                            $.each(series, function(index2) {
                                new_data.push({
                                    name:series[index2].name,
                                    y:parseInt(series[index2].y)
                                });
                            });
                            if(index+1==datas[index1].length){
                                axes.push({
                                    name:nome,
                                    type:data[index].tipo,
                                    data:new_data
                                });
                            }else{
                                axes.push({
                                    name:nome,
                                    yAxis: yAxisC,
                                    type:data[index].tipo,
                                    data:new_data
                                });
                            }
                            yAxisC++;
                            yAxis.push({
                                labels:false,
                                title: false
                            });
                        });

                        // Create the chart
                        var chart= Highcharts.chart(elemento, {
                            chart: {
                                backgroundColor: '#c2e0e1',

                                events: {
                                    // drilldown: function(e) {
                                    //     chart.setTitle({ text: e.point.name });
                                    // },
                                    // drillup: function(e) {
                                    //     chart.setTitle({ text: data[index].titulo });
                                    // }
                                },
                            },
                            exporting: {
                                buttons: {
                                    anotherButton: {

                                        text: textoVoltar,
                                        onclick: function () {
                                            if(filtros.length>0) {
                                                filtros = filtros.slice(0, -1);
                                                mostraGrafico(elemento, pai, filtros, null, []);
                                            }
                                        }
                                    }
                                }
                            },
                            title: {
                                text:  titulo
                            },
                            xAxis: {
                                type: 'category'
                            },
                            yAxis: yAxis,
                            legend: {
                                enabled: false
                            },

                            plotOptions: {
                                series: {
                                    borderWidth: 0,
                                    dataLabels: {
                                        enabled: true
                                    },
                                    colorByPoint: true,
                                    cursor: 'pointer',
                                    point: {
                                        events: {
                                            click: function() {

                                                if (vref > 0)
                                                    mostraGrafico(elemento,vref,event.point.name,vpai,filtros);
                                            }
                                        }
                                    }
                                }
                            },
                            series:axes,
                        });
                    });
                }

            });
        }

    </script>
@endpush