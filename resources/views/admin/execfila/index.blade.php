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
                    <div class="x_panel" id="filaDiv">
                        <div class="x_title">
                            <h2>Fila<small></small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-divFiltroContribuintelink"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="col-md-12 col-sm-6 col-xs-12 form-group has-feedback"  >
                                <select class="form-control" id="FilaTrabId" name="FilaTrabId" placeholder="Fila"  onchange="selectFila(this.value)" >
                                    <option value="" hidden selected disabled>Selecionar Fila</option>
                                    @foreach($FilaTrab as $var)
                                        <option value="{{$var->FilaTrabId}}" >{{$var->FilaTrabSg}} - {{$var->FilaTrabNm}}</option>             
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="x_panel" id="divFiltros" style="display: none">
                        <form class="form-horizontal form-label-left" id="formFiltroParcela"    method="post" action="" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            @include('admin.execfila.filtro-carteira')
                            @include('admin.execfila.filtro-roteiro')
                            @include('admin.execfila.filtro-validacao')
                            @include('admin.execfila.filtro-contribuinte')
                            @include('admin.execfila.filtro-parcela')
                            <div class="item form-group  text-center ">
                                <div class="col-md-12 col-sm-12 col-xs-12"  data-toggle="buttons">
                                    <label class="btn btn-default  ">
                                        <input type="radio" name="tipoexec" id="tipoexecV" value="v" > Validação de Envio
                                    </label>
                                    <label class="btn btn-default active">
                                        <input type="radio" name="tipoexec" id="tipoexecF" value="f" checked="checked"> Execução de Fila
                                    </label>
                                </div>
                            </div>
                            <div class="x_panel text-center " style="background-color: #BDBDBD" id="divBotaoFiltrar">
                                <a class="btn btn-app" id="btfiltrar" onclick="filtrarParcelas()" >
                                    <i class="fa fa-filter"></i> Filtrar
                                </a>
                            </div>
                            <div class="x_panel text-center " style="background-color: #BDBDBD; display: none" id="divBotaoFiltrarVal">
                                <a class="btn btn-app" id="btfiltrar" onclick="filtrarValidacao()" >
                                    <i class="fa fa-filter"></i> Filtrar
                                </a>
                            </div>
                            <button id="send" type="submit" class="btn btn-success hidden">Salvar</button>
                        </form>
                    </div>
                        @include('admin.execfila.result-contribuinte')
                        @include('admin.execfila.result-validacao')
                        @include('admin.execfila.result-im')
                        @include('admin.execfila.result-parcela')


                    <form  id="formParcelas" method="post" action="{{ route('execfila.store') }}" >
                        {{ csrf_field() }}
                        <input type="hidden" id="filaId" name="filaId">
                        <input type="hidden" id="parcelas" name="parcelas">
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback text-center">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="item form-group">
                                    <label for="gravar">Gravar</label>
                                    <label><input type="checkbox" id="gravar"   name="gravar"  value="1" class="js-switch" ></label>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="item form-group">
                                <label for="gCSV">CSV</label>
                                <label><input type="checkbox" id="gCSV"   name="gCSV"  value="1" class="js-switch" ></label>
                            </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="item form-group">
                                <label for="gTXT">TXT</label>
                                <label><input type="checkbox" id="gTXT"   name="gTXT"  value="1" class="js-switch" ></label>
                            </div>
                            </div>
                        </div>
                    </form>

                    <div class="x_panel text-center">

                        <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                        <a class="btn btn-app "    id="execFila">
                            <i class="fa fa-save"></i> Executar
                        </a>
                            <a class="btn btn-app "    id="execValida" style="display: none">
                                <i class="fa fa-save"></i> Executar
                            </a>
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
        function addRoteiro(obj) {
            console.log(obj);
            if ( $( "#roteirosId"+obj.value ).length ) {
                $( "#roteirosId"+obj.value ).remove();
            }else{
                $('#formFiltroParcela').append('<input type="hidden" id="roteirosId'+obj.value+'" name="roteirosId[]" value='+obj.value+' />');
            }

        }
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
    <script src="https://cdn.datatables.net/select/1.1.2/js/dataTables.select.min.js"></script>
    <script src="http://kingkode.com/datatables.editor.lite/js/altEditor/dataTables.altEditor.free.js"></script>
    <script type="text/javascript">


        function filtrarParcelas(){
            $("#divResultValidacaoRes").hide();
            $("#divResultContribuinteRes").show();
            $("#divResultIM").hide();
            $("#divResultParcela").show();
            var tbContribuinteRes = $('#tbContribuinteRes').DataTable();
            var url = "{{ route('execfila.getdataParcela') }}"+"/?group=Pes&"+$('#formFiltroParcela').serialize()+'&FilaTrabId='+$('#FilaTrabId').val();
            tbContribuinteRes.ajax.url(url).load();

            {{--var tbIM = $('#tbIMRes').DataTable();--}}
            {{--var url = "{{ route('execfila.getdataParcela') }}"+"/?group=IM&"+$('#formFiltroParcela').serialize()+'&FilaTrabId='+$('#FilaTrabId').val();--}}
            {{--tbIM.ajax.url(url).load();--}}

            var tbParcela = $('#tbParcela').DataTable();
            var url = "{{ route('execfila.getdataParcela') }}"+"/?"+$('#formFiltroParcela').serialize()+'&FilaTrabId='+$('#FilaTrabId').val();
            tbParcela.ajax.url(url).load();
        }
        function filtrarValidacao() {
            $("#divResultValidacaoRes").show();
            $("#divResultContribuinteRes").hide();
            $("#divResultIM").hide();
            $("#divResultParcela").hide();
            var tbValidacaoRes = $('#tbValidacaoRes').DataTable();
            var url = "{{ route('execfila.getDadosValidar') }}"+"/?group=Pes&"+$('#formFiltroParcela').serialize()+'&FilaTrabId='+$('#FilaTrabId').val();
            tbValidacaoRes.ajax.url(url).load();

        }
        function selectFila(fila) {
            $('#divFiltros').show();
            $.ajax({
                type: 'GET',
                dataType: 'json',
                data: {
                    _token: '{!! csrf_token() !!}',
                    fila: fila
                },
                url: '{{ url('admin/execfila/getDadosFila') }}',
                success: function( result ) {
                    if(result.filtro_carteira==1){
                        $('#divFiltroCarteira').show();
                    }else{
                        $('#divFiltroCarteira').hide();
                    }
                    if(result.filtro_roteiro==1){
                        $('#divFiltroRoteiro').show();
                    }else{
                        $('#divFiltroRoteiro').hide();
                    }
                    if(result.filtro_contribuinte==1){
                        $('#divFiltroContribuinte').show();
                    }else{
                        $('#divFiltroContribuinte').hide();
                    }

                    if(result.filtro_parcelas==1){
                        $('#divFiltroParcela').show();
                    }else{
                        $('#divFiltroParcela').hide();
                    }

                    if(result.resultado_contribuinte==1){
                        $('#divResultContribuinteRes').show();
                    }else{
                        $('#divResultContribuinteRes').hide();
                    }

                    if(result.resultado_im==1){
                        $('#divResultIM').hide();
                    }else{
                        $('#divResultIM').hide();
                    }

                    if(result.resultado_parcelas==1){
                        $('#divResultParcela').show();
                    }else{
                        $('#divResultParcela').hide();
                    }

                    if(result.resultado_canais==1){
                        $('#divResultValidacaoRes').show();
                        $('#tipoexecV').parent( "label" ).show();

                    }else{
                        $('#divResultValidacaoRes').hide();
                        $('#tipoexecV').parent( "label" ).hide();
                    }
                    if(result.filtro_validacao==1){
                        $('#divFiltroValidacao').show();

                    }else{
                        $('#divFiltroValidacao').hide();
                    }
                }
            });
            filtrarCarteira(fila);
            filtrarRoteiro(fila);
            filtrarValidacoes(fila);
        }

        function filtrarCarteira(fila){
            var tbCarteira = $('#tbCarteira').DataTable();
            var url = "{{ route('carteira.getdataCarteira') }}"+"/?fila="+fila;
            tbCarteira.ajax.url(url).load();
            tbCarteira.on( 'select', function ( e, dt, type, indexes ) {
                if ( type === 'row' ) {
                    var CARTEIRAID = tbCarteira.rows( indexes ).data().pluck( 'CARTEIRAID' );
                    var tableRoteiro = $('#tbRoteiro').DataTable();
                    var url = "{{ route('execfila.getDadosRoteiro') }}"+"/?CARTEIRAID="+CARTEIRAID[0]+"&fila="+fila;
                    tableRoteiro.ajax.url(url).load();
                }
            }).on( 'deselect', function ( e, dt, type, indexes ){
                var tableRoteiro = $('#tbRoteiro').DataTable();
                var url = "{{ route('execfila.getDadosRoteiro') }}"+"/?CARTEIRAID=a";
                tableRoteiro.ajax.url(url).load();
            });
        }
        function filtrarRoteiro(fila){
            var tbRoteiro = $('#tbRoteiro').DataTable( );
            var url = "{{ route('execfila.getDadosRoteiro') }}"+"/?CARTEIRAID=a&fila="+fila;
            tbRoteiro.ajax.url(url).load();
        }
        function filtrarValidacoes(fila){
            var tbRoteiro = $('#tbValidacao').DataTable( );
            var url = "{{ route('execfila.getDadosDataTableValidacoes') }}"+"/?fila="+fila;
            tbRoteiro.ajax.url(url).load();
        }
        function updateDataTableSelectAllCtrl(tbParcela){
            var $table             = tbParcela.table().node();
            var $chkbox_all        = $('tbody input[type="checkbox"]', $table);
            var $chkbox_checked    = $('tbody input[type="checkbox"]:checked', $table);
            var chkbox_select_all  = $('thead input[name="select_all"]', $table).get(0);

            // If none of the checkboxes are checked
            if($chkbox_checked.length === 0){
                chkbox_select_all.checked = false;
                if('indeterminate' in chkbox_select_all){
                    chkbox_select_all.indeterminate = false;
                }

                // If all of the checkboxes are checked
            } else if ($chkbox_checked.length === $chkbox_all.length){
                chkbox_select_all.checked = true;
                if('indeterminate' in chkbox_select_all){
                    chkbox_select_all.indeterminate = false;
                }

                // If some of the checkboxes are checked
            } else {
                chkbox_select_all.checked = true;
                if('indeterminate' in chkbox_select_all){
                    chkbox_select_all.indeterminate = true;
                }
            }
        }

        $(document).ready(function() {
            var rows_selected = [];


            var tbRoteiro = $('#tbRoteiro').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                "searching": false,
                "paging":   false,
                "ordering": false,
                "info":     false,
                ajax: '{{ route('carteira.getdataRoteiro') }}',

                columns: [
                    {
                        data:null,
                        name:"check",
                        searchable: false,
                        orderable: false,
                        width: '1%',
                        className: 'col-lg-1 col-centered',
                        render: function (data, type, full, meta) {
                            if ( $( "#roteirosId"+data.RoteiroId ).length ) {
                                return '<input type="checkbox" name="roteiros[]" checked value="' + data.RoteiroId + '" onchange="addRoteiro(this)">';
                            }else{
                                return '<input type="checkbox" name="roteiros[]" value="' + data.RoteiroId + '" onchange="addRoteiro(this)">';
                            }
                        },
                        createdCell: function (td, cellData, rowData, row, col) {
                            $(td).prop("scope", "row");
                        }
                    },
                    {data: 'RoteiroOrd', name: 'RoteiroOrd'},
                    {data: 'FaseCartNM', name: 'FaseCartNM'},
                    {data: 'EventoNM', name: 'EventoNM'},
                    {data: 'ModComNM', name: 'ModComNM'},
                    {data: 'FilaTrabNM', name: 'FilaTrabNM'},
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
            // tbRoteiro.on( 'select', function ( e, dt, type, indexes ) {
            //     if ( type === 'row' ) {
            //         var RoteiroId = tbRoteiro.rows( indexes ).data().pluck( 'RoteiroId' );
            //         $('#formFiltroParcela').append('<input type="hidden" id="roteirosId'+RoteiroId[0]+'" name="roteirosId[]" value='+RoteiroId[0]+' />');
            //     }
            // })
            // .on( 'deselect', function ( e, dt, type, indexes ){
            //     if ( type === 'row' ) {
            //         var RoteiroId = tbRoteiro.rows( indexes ).data().pluck( 'RoteiroId' );
            //         $( "#roteirosId"+RoteiroId[0] ).remove();
            //     }
            // });

            var tbCarteira = $('#tbCarteira').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                "searching": false,
                "paging":   false,
                "ordering": false,
                "info":     false,

                ajax: '{{ route('carteira.getdataCarteira') }}',
                select: {
                    style: 'single',
                    info:false
                },
                columns: [
                    {
                        data:null,
                        name:"check",
                        searchable: false,
                        orderable: false,
                        width: '1%',
                        className: 'col-lg-1 col-centered',
                        render: function (data, type, full, meta) {

                            return '<input type="checkbox" name="CARTEIRAID[]" value="'+data.CARTEIRAID+'">';
                        },
                        createdCell: function (td, cellData, rowData, row, col) {
                            $(td).prop("scope", "row");
                        }
                    },
                    {data: 'CARTEIRAORD', name: 'CARTEIRAORD'},
                    {data: 'CARTEIRASG', name: 'CARTEIRASG'},
                    {
                        data: 'CARTEIRAID',
                        name: 'CARTEIRAID',
                        "visible": false,
                        "searchable": false
                    },
                ],
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json"
                }
            });


            var tbValidacao = $('#tbValidacao').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                "searching": false,
                "paging":   false,
                "ordering": false,
                "info":     false,
                ajax: '{{ route('execfila.getDadosValidacao') }}',
                select: {
                    style: 'multiple',
                    info:false
                },
                columns: [
                    {
                        data: 'REGTABSG',
                        name: 'REGTABSG'
                    },
                    {
                        data: 'REGTABNM',
                        name: 'REGTABNM'
                    },
                    {
                        data: 'EventoSg',
                        name: 'EventoSg'
                    },
                    {
                        data: 'EventoId',
                        name: 'EventoId',
                        "visible": false,
                        "searchable": false
                    },
                    {
                        data: 'ValEnvId',
                        name: 'ValEnvId',
                        "visible": false,
                        "searchable": false
                    },
                    {
                        data: 'id',
                        name: 'id',
                        "visible": false,
                        "searchable": false
                    }
                ],
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json"
                }
            });


            var tbFxAtraso = $('#tbFxAtraso').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                "searching": false,
                "paging":   false,
                "ordering": false,
                "info":     false,
                ajax: '{{ route('execfila.getdataFxAtraso') }}',
                select: {
                    style: 'multi',
                    info:false
                },
                columns: [
                    {data: 'REGTABSG', name: 'REGTABSG'},
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
                    $('#formFiltroParcela').append('<input type="hidden" id="FxAtrasoId'+FxAtrasoId[0]+'" name="FxAtrasoId[]" value='+FxAtrasoId[0]+' />');
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
                "searching": false,
                "paging":   false,
                "ordering": false,
                "info":     false,
                ajax: '{{ route('execfila.getdataFxValor') }}',
                select: {
                    style: 'multi',
                    info:false
                },
                columns: [
                    {data: 'REGTABSG', name: 'REGTABSG'},
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
                    $('#formFiltroParcela').append('<input type="hidden" id="FxValorId'+FxValorId[0]+'" name="FxValorId[]" value='+FxValorId[0]+' />');
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
                    {
                        'targets': 0,
                        'searchable': false,
                        'orderable': false,
                        'width': '1%',
                        'className': 'dt-body-center',
                        'render': function (data, type, full, meta){
                            return '<input type="checkbox">';
                        }
                    },
                    {data: 'Carteira', name: 'Carteira'},
                    {data: 'Nome', name: 'Nome'},
                    {data: 'SitPag', name: 'SitPag'},
                    {data: 'SitCob', name: 'SitCob'},
                    {data: 'OrigTrib', name: 'OrigTrib'},
                    {data: 'Trib', name: 'Trib'},
                    {data: 'LancamentoNr', name: 'LancamentoNr'},
                    {data: 'ParcelaNr', name: 'ParcelaNr'},
                    {data: 'PlanoQt', name: 'PlanoQt'},
                    {data: 'VencimentoDt', name: 'VencimentoDt'},
                    {data: 'TotalVr', name: 'TotalVr'},
                    // {data: 'FxAtraso', name: 'FxAtraso'},
                    // {data: 'FxValor', name: 'FxValor'},
                    {
                        data: 'ParcelaId',
                        name: 'ParcelaId',
                        "visible": false,
                        "searchable": false
                    },
                ],
                columnDefs: [
                    {
                        targets: 10,
                        className: 'text-right'
                    }
                ],
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json"
                },
                'rowCallback': function(row, data, dataIndex){
                    // Get row ID
                    var rowId = data['ParcelaId'];

                    // If row ID is in the list of selected row IDs
                    if($.inArray(rowId, rows_selected) !== -1){
                        $(row).find('input[type="checkbox"]').prop('checked', true);
                        $(row).addClass('selected');
                    }
                }
            });

            // Handle click on checkbox
            $('#tbParcela tbody').on('click', 'input[type="checkbox"]', function(e){
                var $row = $(this).closest('tr');

                // Get row data
                var data = tbParcela.row($row).data();

                // Get row ID
                var rowId = data['ParcelaId'];

                // Determine whether row ID is in the list of selected row IDs
                var index = $.inArray(rowId, rows_selected);

                // If checkbox is checked and row ID is not in list of selected row IDs
                if(this.checked && index === -1){
                    rows_selected.push(rowId);

                    // Otherwise, if checkbox is not checked and row ID is in list of selected row IDs
                } else if (!this.checked && index !== -1){
                    rows_selected.splice(index, 1);
                }

                if(this.checked){
                    $row.addClass('selected');
                } else {
                    $row.removeClass('selected');
                }

                // Update state of "Select all" control
                updateDataTableSelectAllCtrl(tbParcela);

                // Prevent click event from propagating to parent
                e.stopPropagation();
            });

            // Handle click on table cells with checkboxes
            $('#tbParcela').on('click', 'tbody td, thead th:first-child', function(e){
                $(this).parent().find('input[type="checkbox"]').trigger('click');
            });

            // Handle click on "Select all" control
            $('thead input[name="select_all"]', tbParcela.table().container()).on('click', function(e){
                if(this.checked){
                    $('#tbParcela tbody input[type="checkbox"]:not(:checked)').trigger('click');
                } else {
                    $('#tbParcela tbody input[type="checkbox"]:checked').trigger('click');
                }

                // Prevent click event from propagating to parent
                e.stopPropagation();
            });

            // Handle table draw event
            tbParcela.on('draw', function(){
                // Update state of "Select all" control
                updateDataTableSelectAllCtrl(tbParcela);
            });


            $('#execFila').on('click', function(e){
                if($("#FilaTrabId").val()>0) {
                    if(rows_selected.length !== 0) {
                        $('#filaId').val($('#FilaTrabId').val());
                        $('#parcelas').val(rows_selected);
                        $('#formParcelas').submit();
                    }else {
                        swal({
                            position: 'top-end',
                            type: 'error',
                            title: 'Selecione pelo menos uma parcela!',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                }else{
                    swal({
                        position: 'top-end',
                        type: 'error',
                        title: 'Selecione uma Fila no filtro!',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            });


            var tbSitPag = $('#tbSitPag').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                "searching": false,
                "paging":   false,
                "ordering": false,
                "info":     false,
                ajax: '{{ route('execfila.getdataSitPag') }}',
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

            tbSitPag.on( 'select', function ( e, dt, type, indexes ) {
                if ( type === 'row' ) {
                    var SitPagId = tbSitPag.rows( indexes ).data().pluck( 'REGTABID' );
                    $('#formFiltroParcela').append('<input type="hidden" id="SitPagId'+SitPagId[0]+'" name="SitPagId[]" value='+SitPagId[0]+' />');
                }
            }).on( 'deselect', function ( e, dt, type, indexes ){
                    if ( type === 'row' ) {
                        var SitPagId = tbSitPag.rows( indexes ).data().pluck( 'REGTABID' );
                        $( "#SitPagId"+SitPagId[0] ).remove();
                    }
            });

            var tbSitCob = $('#tbSitCob').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                "searching": false,
                "paging":   false,
                "ordering": false,
                "info":     false,
                ajax: '{{ route('execfila.getdataSitCob') }}',
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

            tbSitCob.on( 'select', function ( e, dt, type, indexes ) {
                if ( type === 'row' ) {
                    var SitCobId = tbSitCob.rows( indexes ).data().pluck( 'REGTABID' );
                    $('#formFiltroParcela').append('<input type="hidden" id="SitCobId'+SitCobId[0]+'" name="SitCobId[]" value='+SitCobId[0]+' />');
                }
            }).on( 'deselect', function ( e, dt, type, indexes ){
                if ( type === 'row' ) {
                    var SitCobId = tbSitCob.rows( indexes ).data().pluck( 'REGTABID' );
                    $( "#SitCobId"+SitCobId[0] ).remove();
                }
            });

            var tbOrigTrib = $('#tbOrigTrib').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                "searching": false,
                "paging":   false,
                "ordering": false,
                "info":     false,
                ajax: '{{ route('execfila.getdataOrigTrib') }}',
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

            tbOrigTrib.on( 'select', function ( e, dt, type, indexes ) {
                if ( type === 'row' ) {
                    var OrigTribId = tbOrigTrib.rows( indexes ).data().pluck( 'REGTABID' );
                    $('#formFiltroParcela').append('<input type="hidden" id="OrigTribId'+OrigTribId[0]+'" name="OrigTribId[]" value='+OrigTribId[0]+' />');
                }
            }).on( 'deselect', function ( e, dt, type, indexes ){
                if ( type === 'row' ) {
                    var OrigTribId = tbOrigTrib.rows( indexes ).data().pluck( 'REGTABID' );
                    $( "#OrigTribId"+OrigTribId[0] ).remove();
                }
            });

            var tbTributo = $('#tbTributo').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                "searching": false,
                "paging":   false,
                "ordering": false,
                "info":     false,
                ajax: '{{ route('execfila.getdataTributo') }}',
                select: {
                    style: 'multi',
                    info:false
                },
                columns: [
                    {data: 'REGTABSG', name: 'REGTABSG'},
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

            tbTributo.on( 'select', function ( e, dt, type, indexes ) {
                if ( type === 'row' ) {
                    var TributoId = tbTributo.rows( indexes ).data().pluck( 'REGTABID' );
                    $('#formFiltroParcela').append('<input type="hidden" id="TributoId'+TributoId[0]+'" name="TributoId[]" value='+TributoId[0]+' />');
                }
            }).on( 'deselect', function ( e, dt, type, indexes ){
                if ( type === 'row' ) {
                    var TributoId = tbTributo.rows( indexes ).data().pluck( 'REGTABID' );
                    $( "#TributoId"+TributoId[0] ).remove();
                }
            });


            var tbContribuinteRes = $('#tbContribuinteRes').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '{{ route('execfila.getdataParcela') }}'+"/?limit=0",
                select: {
                    style: 'multi',
                    info:false
                },
                columns: [
                    {data: 'Nome', name: 'Nome'},
                    {data: 'CPFCNPJ', name: 'CPFCNPJ'},
                    {data: 'INSCRMUNNR', name: 'INSCRMUNNR'},
                    {data: 'VencimentoDt', name: 'VencimentoDt'},
                    {data: 'TotalVr', name: 'TotalVr'},
                    {data: 'FxAtraso', name: 'FxAtraso'},
                    {data: 'FxValor', name: 'FxValor'},
                    {
                        data: 'PessoaId',
                        name: 'PessoaId',
                        "visible": false,
                        "searchable": false
                    },
                ],
                columnDefs: [
                    {
                        targets: 3,
                        className: 'text-right'
                    }
                ],
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json"
                }
            });

            tbContribuinteRes.on( 'select', function ( e, dt, type, indexes ) {
                if ( type === 'row' ) {
                    var ContribuinteResId = tbContribuinteRes.rows( indexes ).data().pluck( 'PessoaId' );
                    $('#formFiltroParcela').append('<input type="hidden" id="ContribuinteResId'+ContribuinteResId[0]+'" name="ContribuinteResId[]" value='+ContribuinteResId[0]+' />');
                    var tbParcela = $('#tbParcela').DataTable();
                    var url = "{{ route('execfila.getdataParcela') }}"+"/?"+$('#formFiltroParcela').serialize()+'&FilaTrabId='+$('#FilaTrabId').val();
                    tbParcela.ajax.url(url).load();
                }
            }).on( 'deselect', function ( e, dt, type, indexes ){
                if ( type === 'row' ) {
                    var ContribuinteResId = tbContribuinteRes.rows( indexes ).data().pluck( 'PessoaId' );
                    $( "#ContribuinteResId"+ContribuinteResId[0] ).remove();
                    var tbParcela = $('#tbParcela').DataTable();
                    var url = "{{ route('execfila.getdataParcela') }}"+"/?"+$('#formFiltroParcela').serialize()+'&FilaTrabId='+$('#FilaTrabId').val();
                    tbParcela.ajax.url(url).load();
                }
            });

            $('input:radio[name="tipoexec"]').change(
                function(){
                    if (this.checked && this.value == 'v') {
                        $("#divBotaoFiltrar").hide();
                        $("#divBotaoFiltrarVal").show();

                        $("#divResultValidacaoRes").show();
                        $("#divResultContribuinteRes").hide();
                        $("#divResultIM").hide();
                        $("#divResultParcela").hide();
                        $("#execFila").hide();
                        $("#execValida").show();

                    }
                    if (this.checked && this.value == 'f') {
                        $("#divBotaoFiltrarVal").hide();
                        $("#divBotaoFiltrar").show();
                        $("#divResultValidacaoRes").hide();
                        $("#divResultContribuinteRes").show();
                        $("#divResultIM").hide();
                        $("#divResultParcela").show();

                        $("#execFila").show();
                        $("#execValida").hide();
                    }
                });

            var tbValidacaoRes = $('#tbValidacaoRes').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                "searching": false,
                "paging":   false,
                "ordering": false,
                "info":     false,
                ajax: '{{ route('execfila.getDadosValidar') }}?none=true',
                // select: {
                //     style: 'multiple',
                //     info:false
                // },
                columns: [
                    {
                        data: 'Nome',
                        name: 'Nome'
                    },
                    {
                        data: 'Canal',
                        name: 'Canal'
                    },
                    {
                        data: 'Dados',
                        name: 'Dados'
                    },
                    {
                        data: 'Evento',
                        name: 'Evento'
                    },
                    {
                        data: 'PsCanalId',
                        name: 'PsCanalId',
                        "visible": false,
                        "searchable": false
                    }
                ],
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json"
                }
            });

            $('#execValida').on('click', function(e){
                var table = $('#tbValidacaoRes').DataTable();
                var data = table.rows().data().toArray();
                var csv =  $('#gCSV').is(':checked');
                var txt =  $('#gTXT').is(':checked');
                var gravar =  $('#gravar').is(':checked');
                if(data.length>0) {
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        data: {
                            _token: '{!! csrf_token() !!}',
                            dados:JSON.stringify(data),
                            csv:csv,
                            gravar:gravar,
                            txt:txt
                        },
                        url: '{{ route('execfila.validar') }}',
                        success: function (retorno) {
                            swal({
                                position: 'top-end',
                                type: 'success',
                                title: 'Execução de Validação enviada para lista de tarefas!',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            window.location = "{{route('execfila.index')}}";
                        },
                        error: function (retorno) {
                            swal({
                                position: 'top-end',
                                type: 'error',
                                title: 'Error'+retorno,
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }
                    });
                }else{
                    swal({
                        position: 'top-end',
                        type: 'error',
                        title: 'Nenhum dado para validar!',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            });


        }); // document ready


    </script>
@endpush