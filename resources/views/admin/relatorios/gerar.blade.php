@extends('layouts.app')
@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/select/1.1.2/css/select.dataTables.min.css" rel="stylesheet">
@endsection
@section('content')
    <!-- page content -->
    @include('vendor.sweetalert.cdn')
    @include('vendor.sweetalert.view')
    @include('vendor.sweetalert.validator')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Gerar relatório - {{strtoupper($rel->rel_titulo)}}</h3>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">

                    <div class="x_panel " >
                        <div class="x_title">
                            <h2>Filtros<small></small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a></li>

                            </ul>

                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content " style="display: none;">
                            <form class="form-horizontal form-label-left" id="formFiltro"    method="post" action="" enctype="multipart/form-data">
                                {{ csrf_field() }}

                                <a href="#">
                                    <div class="mail_list"></div>
                                </a>
                                @foreach($rel->parametros as $parametro)
                                    <div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback">
                                        <input type="text" class="form-control has-feedback-left @if($parametro->rep_tipo=='data') date-picker @endif" style="padding-right: 1px !important;" placeholder="{{$parametro->rep_descricao}}" id="{{$parametro->rep_parametro}}" name="{{$parametro->rep_parametro}}" aria-describedby="inputSuccess2Status">
                                        @if($parametro->rep_tipo=='data')<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>@endif
                                        <span id="inputSuccess2Status" class="sr-only">(success)</span>
                                    </div>
                                @endforeach
                                <a href="#">
                                    <div class="mail_list"></div>
                                </a>
                                <div class="x_panel text-center" style="background-color: #BDBDBD">
                                    <a class="btn btn-app" id="btfiltrar" onclick="filtrarRegistros()" >
                                        <i class="fa fa-filter"></i> Filtrar
                                    </a>
                                </div>
                                <button id="send" type="submit" class="btn btn-success hidden">Salvar</button>
                            </form>
                        </div>
                    </div>


                    <div class="x_panel" id="pnHoraExec">
                        <div class="x_title">
                            <h2>Registros<small></small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="true"><i class="fa fa-download"></i></a>
                                    <ul class="dropdown-menu" role="menu" style="background-color: #f0f0f0">
                                        <li><a href="{{route("pessoa.export",["tipo"=>'pdf'])}}" target="_blank"><i class="fa fa-file-pdf-o"></i> PDF</a></li>
                                        <li><a href="{{route("pessoa.export",["tipo"=>'csv'])}}" target="_blank"><i class="fa fa-file-excel-o"></i> CSV</a></li>
                                        <li><a href="{{route("pessoa.export",["tipo"=>'txt'])}}" target="_blank"><i class="fa fa-file-text-o"></i> TXT</a></li>
                                    </ul>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            <table id="tbRegistro" class="table table-hover table-bordered table-striped datatable display responsive nowrap" style="width:100%; font-size: 9px">
                                <thead>
                                <tr>
                                    @foreach($campos as $campo)
                                        <th>{{ucfirst(strtolower($campo))}}</th>
                                    @endforeach
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- /page content -->
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js">
        jQuery(function($){
            $.datepicker.regional['pt-BR'] = {
                closeText: 'Fechar',
                prevText: '&#x3c;Anterior',
                nextText: 'Pr&oacute;ximo&#x3e;',
                currentText: 'Hoje',
                monthNames: ['Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho',
                    'Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
                monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun',
                    'Jul','Ago','Set','Out','Nov','Dez'],
                dayNames: ['Domingo','Segunda-feira','Ter&ccedil;a-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sabado'],
                dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
                dayNamesMin: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
                weekHeader: 'Sm',
                dateFormat: 'dd/mm/yy',
                firstDay: 0,
                isRTL: false,
                showMonthAfterYear: false,
                yearSuffix: ''};
            $.datepicker.setDefaults($.datepicker.regional['pt-BR']);
        });

    </script>

    <script type="text/javascript">

        $(function() {
            $('.date-picker').daterangepicker({
                singleDatePicker: true,
                autoUpdateInput: false,
                "locale": {
                    "format": "DD/MM/YYYY",
                    "separator": " - ",
                    "applyLabel": "Aplicar",
                    "cancelLabel": "Cancelar",
                    "fromLabel": "De",
                    "toLabel": "Até",
                    "customRangeLabel": "Custom",
                    "daysOfWeek": [
                        "Dom",
                        "Seg",
                        "Ter",
                        "Qua",
                        "Qui",
                        "Sex",
                        "Sáb"
                    ],
                    "monthNames": [
                        "Janeiro",
                        "Fevereiro",
                        "Março",
                        "Abril",
                        "Maio",
                        "Junho",
                        "Julho",
                        "Agosto",
                        "Setembro",
                        "Outubro",
                        "Novembro",
                        "Dezembro"
                    ],
                    "firstDay": 0
                }
            }, function(chosen_date) {
                if(this.element.attr('id')=='CompetenciaInicio' || this.element.attr('id')=='CompetenciaFinal'){
                    this.element.val(chosen_date.format('MM/YYYY'));
                }else{
                    this.element.val(chosen_date.format('DD/MM/YYYY'));
                }
            });
        });
    </script>

    @include('vendor.sweetalert.cdn')
    @include('vendor.sweetalert.view')
    @include('vendor.sweetalert.validator')
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript">

        function filtrarRegistros(){
            var tbRegistro = $('#tbRegistro').DataTable();
            var url;
            tbRegistro.ajax.url(url).load();
        }


        $(document).ready(function() {


            var tbRegistro = $('#tbRegistro').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '{{ route('relatorios.getdataRegistro') }}'+"/?limit=0&sql={!! $rel->rel_sql !!}",
                "pageLength": 100,
                columns: [
                    @foreach($campos as $campo)
                        {data:  '{!! $campo !!}', name: '{!! $campo !!}'},
                    @endforeach
                ],
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json"
                }
            });


        });
    </script>
@endpush