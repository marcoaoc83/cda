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
                    <h3>Execução de Fila</h3>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">

                    <div class="x_panel " >
                        <div class="x_title">
                            <h2>Filtros<small></small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content " style="display: none;">
                            <form class="form-horizontal form-label-left" id="formFiltro"    method="post" action="" enctype="multipart/form-data">
                                {{ csrf_field() }}

                                <div class="col-md-12 col-sm-6 col-xs-12 form-group has-feedback"  >
                                    <select class="form-control" id="FilaTrabId" name="FilaTrabId" placeholder="Fila"  onchange="filtrarCarteira(this.value)" >
                                        <option value="" hidden selected disabled>Selecionar Fila</option>
                                        @foreach($FilaTrab as $var)
                                            <option value="{{$var->FilaTrabId}}" >{{$var->FilaTrabSg}} - {{$var->FilaTrabNm}}</option>             
                                        @endforeach
                                    </select>
                                </div>
                                <a href="#">
                                    <div class="mail_list"></div>
                                </a>
                                <div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback">
                                    <input type="text" class="form-control has-feedback-left date-picker" placeholder="Vc Inicio" id="VencimentoInicio" name="VencimentoInicio" aria-describedby="inputSuccess2Status">
                                    <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                    <span id="inputSuccess2Status" class="sr-only">(success)</span>
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback">
                                    <input type="text" class="form-control has-feedback-left date-picker" placeholder="Vc Final" id="VencimentoFinal" name="VencimentoFinal" aria-describedby="inputSuccess2Status">
                                    <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                    <span id="inputSuccess2Status" class="sr-only">(success)</span>
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback">
                                    <input type="text" class="form-control has-feedback-left date-picker" placeholder="Cpt Inicio" id="CompetenciaInicio" name="CompetenciaInicio" aria-describedby="inputSuccess2Status">
                                    <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                    <span id="inputSuccess2Status" class="sr-only">(success)</span>
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback">
                                    <input type="text" class="form-control has-feedback-left date-picker" placeholder="Cpt Final" id="CompetenciaFinal" name="CompetenciaFinal" aria-describedby="inputSuccess2Status">
                                    <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                    <span id="inputSuccess2Status" class="sr-only">(success)</span>
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback">
                                    <input id="middle-name" class="form-control col-md-7 col-xs-12" type="text" name="nmaiores" placeholder="N Maiores">
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback">
                                    <input id="middle-name" class="form-control col-md-7 col-xs-12" type="text" name="nmenores" placeholder="N Menores">
                                </div>
                                <a href="#">
                                    <div class="mail_list"></div>
                                </a>
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                                    <h2>Carteira e Roteiro</h2>
                                    <table id="tbRoteiro" class="table table-hover table-bordered table-striped datatable display responsive nowrap" style="width:100%">
                                        <thead>
                                        <tr>
                                            <th>Carteira</th>
                                            <th>Fase Cart</th>
                                            <th>Evento</th>
                                            <th>Modelo</th>
                                            <th>Canal</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                                <a href="#">
                                    <div class="mail_list"></div>
                                </a>
                                <div class="col-md-6 col-sm-6 col-xs-6 form-group has-feedback">
                                    <h2>Faixa Atraso</h2>
                                    <table id="tbFxAtraso" class="table table-hover table-bordered table-striped datatable display responsive nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Faixa</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6 form-group has-feedback">
                                    <h2>Faixa Valor</h2>
                                    <table id="tbFxValor" class="table table-hover table-bordered table-striped datatable display responsive nowrap" style="width:100%">
                                        <thead>
                                        <tr>
                                            <th>Faixa</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="x_panel text-center" style="background-color: #BDBDBD">
                                    <a class="btn btn-app" id="btfiltrar" onclick="filtrarParcelas()" >
                                        <i class="fa fa-filter"></i> Filtrar
                                    </a>
                                </div>
                                <button id="send" type="submit" class="btn btn-success hidden">Salvar</button>
                            </form>
                        </div>
                    </div>


                    <div class="x_panel" id="pnHoraExec">
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
                                    <th>Nome</th>
                                    <th>Sit Pag</th>
                                    <th>Orig Trib</th>
                                    <th>Lcto</th>
                                    <th>Pc</th>
                                    <th>Pl</th>
                                    <th>Vencimento</th>
                                    <th>Valor</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <form  id="formParcelas" method="post" action="{{ route('execfila.store') }}" >
                        {{ csrf_field() }}
                        <input type="hidden" id="dados" name="dados">
                    </form>
                    <div class="x_panel text-center">
                        <a class="btn btn-app "    onclick="execFila()">
                            <i class="fa fa-save"></i> Executar Fila
                        </a>
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
                this.element.val(chosen_date.format('DD/MM/YYYY'));
            });
        });
    </script>

    @include('vendor.sweetalert.cdn')
    @include('vendor.sweetalert.view')
    @include('vendor.sweetalert.validator')
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.1.2/js/dataTables.select.min.js"></script>
    <script src="http://kingkode.com/datatables.editor.lite/js/altEditor/dataTables.altEditor.free.js"></script>
    <script type="text/javascript">

        function filtrarParcelas(){
            var tbParcela = $('#tbParcela').DataTable();
            var url = "{{ route('execfila.getdataParcela') }}"+"/?"+$('#formFiltro').serialize();
            tbParcela.ajax.url(url).load();
        }

        function execFila() {
            if($("#FilaTrabId").val()>0) {
                $('#dados').val($('#formFiltro').serialize());
                $('#formParcelas').submit();
            }else{
                swal({
                    position: 'top-end',
                    type: 'error',
                    title: 'Selecione uma Fila no filtro!',
                    showConfirmButton: false,
                    timer: 1500
                })
            }
        }

        function filtrarCarteira(fila){
            var tbRoteiro = $('#tbRoteiro').DataTable();
            var url = "{{ route('carteira.getdataRoteiro') }}"+"/?fila="+fila;
            tbRoteiro.ajax.url(url).load();
        }

        $(document).ready(function() {

            var tbRoteiro = $('#tbRoteiro').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '{{ route('carteira.getdataRoteiro') }}',
                select: {
                    style: 'multi',
                    info:false
                },
                columns: [
                    {data: 'CARTEIRASG', name: 'CARTEIRASG'},
                    {data: 'FaseCartNM', name: 'FaseCartNM'},
                    {data: 'EventoNM', name: 'EventoNM'},
                    {data: 'ModComNM', name: 'ModComNM'},
                    {data: 'CanalNM', name: 'CanalNM'},
                    {
                        data: 'RoteiroId',
                        name: 'RoteiroId',
                        "visible": false,
                        "searchable": false
                    },
                ],
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json"
                }
            });
            tbRoteiro.on( 'select', function ( e, dt, type, indexes ) {
                if ( type === 'row' ) {
                    var RoteiroId = tbRoteiro.rows( indexes ).data().pluck( 'RoteiroId' );
                    $('#formFiltro').append('<input type="hidden" id="roteirosId'+RoteiroId[0]+'" name="roteirosId[]" value='+RoteiroId[0]+' />');
                }
            })
            .on( 'deselect', function ( e, dt, type, indexes ){
                if ( type === 'row' ) {
                    var RoteiroId = tbRoteiro.rows( indexes ).data().pluck( 'RoteiroId' );
                    $( "#roteirosId"+RoteiroId[0] ).remove();
                }
            });



            var tbFxAtraso = $('#tbFxAtraso').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                "pageLength": 25,
                ajax: '{{ route('execfila.getdataFxAtraso') }}',
                select: {
                    style: 'multi',
                    info:false
                },
                columns: [
                    {data: 'REGTABNM', name: 'REGTABNM'},
                    {
                        data: 'REGTABID',
                        name: 'REGTABID',
                        "visible": false,
                        "searchable": false
                    },
                ],
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json"
                }
            });
            tbFxAtraso.on( 'select', function ( e, dt, type, indexes ) {
                if ( type === 'row' ) {
                    var FxAtrasoId = tbFxAtraso.rows( indexes ).data().pluck( 'REGTABID' );
                    $('#formFiltro').append('<input type="hidden" id="FxAtrasoId'+FxAtrasoId[0]+'" name="FxAtrasoId[]" value='+FxAtrasoId[0]+' />');
                }
            })
            .on( 'deselect', function ( e, dt, type, indexes ){
                if ( type === 'row' ) {
                    var FxAtrasoId = tbFxAtraso.rows( indexes ).data().pluck( 'REGTABID' );
                    $( "#FxAtrasoId"+FxAtrasoId[0] ).remove();
                }
            });



            var tbFxValor = $('#tbFxValor').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                "pageLength": 25,
                ajax: '{{ route('execfila.getdataFxValor') }}',
                select: {
                    style: 'multi',
                    info:false
                },
                columns: [
                    {data: 'REGTABNM', name: 'REGTABNM'},
                    {
                        data: 'REGTABID',
                        name: 'REGTABID',
                        "visible": false,
                        "searchable": false
                    },
                ],
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json"
                }
            });

            tbFxValor.on( 'select', function ( e, dt, type, indexes ) {
                if ( type === 'row' ) {
                    var FxValorId = tbFxValor.rows( indexes ).data().pluck( 'REGTABID' );
                    $('#formFiltro').append('<input type="hidden" id="FxValorId'+FxValorId[0]+'" name="FxValorId[]" value='+FxValorId[0]+' />');
                }
            })
            .on( 'deselect', function ( e, dt, type, indexes ){
                if ( type === 'row' ) {
                    var FxValorId = tbFxValor.rows( indexes ).data().pluck( 'REGTABID' );
                    $( "#FxValorId"+FxValorId[0] ).remove();
                }
            });

            var tbParcela = $('#tbParcela').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '{{ route('execfila.getdataParcela') }}'+"/?limit=0",
                "pageLength": 100,
                columns: [
                    {data: 'Nome', name: 'Nome'},
                    {data: 'SitPag', name: 'SitPag'},
                    {data: 'OrigTrib', name: 'OrigTrib'},
                    {data: 'LancamentoNr', name: 'LancamentoNr'},
                    {data: 'ParcelaNr', name: 'ParcelaNr'},
                    {data: 'PlanoQt', name: 'PlanoQt'},
                    {data: 'VencimentoDt', name: 'VencimentoDt'},
                    {data: 'TotalVr', name: 'TotalVr'},
                    {
                        data: 'ParcelaId',
                        name: 'ParcelaId',
                        "visible": false,
                        "searchable": false
                    },
                ],
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json"
                }
            });

            tbParcela.on( 'select', function ( e, dt, type, indexes ) {
                if ( type === 'row' ) {
                    var ParcelaId = tbParcela.rows( indexes ).data().pluck( 'ParcelaId' );
                    $('#formParcelas').append('<input type="hidden" id="parcelasId'+ParcelaId[0]+'" name="parcelasId[]" value='+ParcelaId[0]+' />');
                }
            })
            .on( 'deselect', function ( e, dt, type, indexes ){
                if ( type === 'row' ) {
                    var ParcelaId = tbParcela.rows( indexes ).data().pluck( 'ParcelaId' );
                    $( "#parcelasId"+ParcelaId[0] ).remove();
                }
            });

        });
    </script>
@endpush