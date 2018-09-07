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
                    <h3>Seus débitos</h3>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel text-center">
                        <a class="btn btn-app "onclick="">
                            <i class="fa fa-eye"></i> Visualizar
                        </a>
                        <a class="btn btn-app "    onclick="">
                            <i class="fa fa-print"></i> Extrato
                        </a>
                        <a class="btn btn-app boleto"    onclick="">
                            <i class="fa fa-barcode"></i> Boleto
                        </a>
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
                        <a class="btn btn-app "onclick="">
                            <i class="fa fa-eye"></i> Visualizar
                        </a>
                        <a class="btn btn-app "    onclick="">
                            <i class="fa fa-print"></i> Extrato
                        </a>
                        <a class="btn btn-app boleto"  >
                            <i class="fa fa-barcode"></i> Boleto
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/md5.js"></script>
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
            $('.boleto').hide();
            var tbParcela = $('#tbParcela').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '{{ route('debitos.getdata') }}'+"/?limit=0",
                "pageLength": 100,
                select: {
                    style: 'single',
                    info: false

                },
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

                    var sit =tbParcela.rows( indexes ).data().pluck( 'SitPag' );
                    if(sit[0]=='Aberta'){
                        $('.boleto').show();
                    }

                }
            })
            .on( 'deselect', function ( e, dt, type, indexes ){
                if ( type === 'row' ) {
                    var ParcelaId = tbParcela.rows( indexes ).data().pluck( 'ParcelaId' );
                    $( "#parcelasId"+ParcelaId[0] ).remove();
                    $('.boleto').hide();
                }
            });

            $('.boleto').click(function () {
                var linha = tbParcela.row('.selected').data();
                window.open('boleto/'+CryptoJS.MD5(linha['ParcelaId']), '_blank');
            });
        });
    </script>
@endpush