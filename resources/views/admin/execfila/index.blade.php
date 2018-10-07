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
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
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
                    <div class="x_panel" id="divFiltros">
                        <form class="form-horizontal form-label-left" id="formFiltroParcela"    method="post" action="" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            @include('admin.execfila.filtro-carteira')
                            @include('admin.execfila.filtro-roteiro')
                            @include('admin.execfila.filtro-contribuinte')
                            @include('admin.execfila.filtro-parcela')

                            <div class="x_panel text-center " style="background-color: #BDBDBD" id="divBotaoFiltrar">
                                <a class="btn btn-app" id="btfiltrar" onclick="filtrarParcelas()" >
                                    <i class="fa fa-filter"></i> Filtrar
                                </a>
                            </div>
                            <button id="send" type="submit" class="btn btn-success hidden">Salvar</button>
                        </form>
                    </div>
                        @include('admin.execfila.result-parcela')


                    <form  id="formParcelas" method="post" action="{{ route('execfila.store') }}" >
                        {{ csrf_field() }}
                        <input type="hidden" id="filaId" name="filaId">
                        <input type="hidden" id="parcelas" name="parcelas">
                    </form>
                    <div class="x_panel text-center">
                        <a class="btn btn-app "    id="execFila">
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
            var tbParcela = $('#tbParcela').DataTable();
            var url = "{{ route('execfila.getdataParcela') }}"+"/?"+$('#formFiltroParcela').serialize()+'&FilaTrabId='+$('#FilaTrabId').val();
            tbParcela.ajax.url(url).load();
        }

        function selectFila(fila) {
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
                    if(result.filtro_roteiro==1){
                        $('#divFiltroContribuinte').show();
                    }else{
                        $('#divFiltroContribuinte').hide();
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
                }
            });
            filtrarCarteira(fila);
            filtrarRoteiro(fila);
        }

        function filtrarCarteira(fila){
            var tbCarteira = $('#tbCarteira').DataTable();
            var url = "{{ route('carteira.getdataCarteira') }}"+"/?fila="+fila;
            tbCarteira.ajax.url(url).load();

        }
        function filtrarRoteiro(fila){
            var tbRoteiro = $('#tbRoteiro').DataTable( );
            var url = "{{ route('carteira.getdataRoteiro') }}"+"/?fila="+fila;
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
                select: {
                    style: 'multi',
                    info:false
                },
                columns: [
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
            tbRoteiro.on( 'select', function ( e, dt, type, indexes ) {
                if ( type === 'row' ) {
                    var RoteiroId = tbRoteiro.rows( indexes ).data().pluck( 'RoteiroId' );
                    $('#formFiltroParcela').append('<input type="hidden" id="roteirosId'+RoteiroId[0]+'" name="roteirosId[]" value='+RoteiroId[0]+' />');
                }
            })
            .on( 'deselect', function ( e, dt, type, indexes ){
                if ( type === 'row' ) {
                    var RoteiroId = tbRoteiro.rows( indexes ).data().pluck( 'RoteiroId' );
                    $( "#roteirosId"+RoteiroId[0] ).remove();
                }
            });

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
                    style: 'multi',
                    info:false
                },
                columns: [
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
            tbCarteira.on( 'select', function ( e, dt, type, indexes ) {
                if ( type === 'row' ) {
                    var CARTEIRAID = tbCarteira.rows( indexes ).data().pluck( 'CARTEIRAID' );
                    $('#formFiltroParcela').append('<input type="hidden" id="CARTEIRAID'+CARTEIRAID[0]+'" name="CARTEIRAID[]" value='+CARTEIRAID[0]+' />');
                }
            })
                .on( 'deselect', function ( e, dt, type, indexes ){
                    if ( type === 'row' ) {
                        var CARTEIRAID = tbCarteira.rows( indexes ).data().pluck( 'CARTEIRAID' );
                        $( "#CARTEIRAID"+CARTEIRAID[0] ).remove();
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
                    {data: 'FxAtraso', name: 'FxAtraso'},
                    {data: 'FxValor', name: 'FxValor'},
                    {
                        data: 'ParcelaId',
                        name: 'ParcelaId',
                        "visible": false,
                        "searchable": false
                    },
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

            var tbContribuinte = $('#tbContribuinte').DataTable({
                responsive: true,
                ajax: '{{ route('pessoa.getdataIM') }}',
                select: {
                    style: 'multi',
                    info:false
                },
                columns: [
                    {data: 'PESSOANMRS', name: 'PESSOANMRS'},
                    {data: 'CPF_CNPJNR', name: 'CPF_CNPJNR'},
                    {data: 'INSCRMUNNR', name: 'INSCRMUNNR'},
                    {
                        data: 'PESSOAID',
                        name: 'PESSOAID',
                        "visible": false,
                        "searchable": false
                    },
                ],
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json"
                }
            });

            tbContribuinte.on( 'select', function ( e, dt, type, indexes ) {
                if ( type === 'row' ) {
                    var ContribuinteId = tbContribuinte.rows( indexes ).data().pluck( 'PESSOAID' );
                    $('#formFiltroParcela').append('<input type="hidden" id="ContribuinteId'+ContribuinteId[0]+'" name="ContribuinteId[]" value='+ContribuinteId[0]+' />');
                }
            }).on( 'deselect', function ( e, dt, type, indexes ){
                if ( type === 'row' ) {
                    var ContribuinteId = tbContribuinte.rows( indexes ).data().pluck( 'PESSOAID' );
                    $( "#ContribuinteId"+ContribuinteId[0] ).remove();
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
        });
    </script>
@endpush