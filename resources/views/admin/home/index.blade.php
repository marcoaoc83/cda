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
            success: function(data){
                $.each(data, function(index) {
                    $("#graficosHome").append('<br><div class=" text-center"><div id="container'+index+'" style="min-width: 310px; height: 400px; margin: 0 auto"></div></div>');
                    var series=data[index].series.data;
                    var nome=data[index].series.name;
                    var pai=data[index].pai;
                    var ref=data[index].ref;
                    var new_data = [];
                    $.each(series, function(index2) {
                        new_data.push({
                            name:series[index2].name,
                            y:parseInt(series[index2].y)
                        });
                    });

                    // Create the chart
                    var chart= Highcharts.chart('container'+index, {
                        chart: {
                            backgroundColor: '#c2e0e1',
                            type: data[index].tipo,
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
                            text:  data[index].titulo
                        },
                        xAxis: {
                            type: 'category'
                        },
                        yAxis: {
                            title: false,
                            labels:false
                        },
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
                                            if (ref > 0)
                                                mostraGrafico("container"+index,ref,event.point.name,pai);
                                        }
                                    }
                                }
                            }
                        },
                        series:[{
                            name: nome,
                            data: new_data
                        }],
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
                success: function(data){
                    $.each(data, function(index) {
                        $(elemento).html(' ');
                        var series=data[index].series.data;
                        var nome=data[index].series.name;
                        var vpai=data[index].pai;
                        var vref=data[index].ref;
                        var new_data = [];
                        if(filtros.length>0) {
                            var textoVoltar='<< Voltar';
                        }else{
                            var textoVoltar='';
                        }

                        $.each(series, function(index2) {
                            new_data.push({
                                name:series[index2].name,
                                y:parseInt(series[index2].y)
                            });
                        });

                        // Create the chart
                        var chart= Highcharts.chart('container'+index, {
                            chart: {
                                type: data[index].tipo,
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
                                text:  data[index].titulo
                            },
                            xAxis: {
                                type: 'category'
                            },
                            yAxis: {
                                title: false,
                                labels:false
                            },
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
                                                    mostraGrafico("container"+index,vref,event.point.name,vpai,filtros);
                                            }
                                        }
                                    }
                                }
                            },
                            series:[{
                                name: nome,
                                data: new_data
                            }],
                        });

                    });
                }
            });
        }

    </script>
@endpush