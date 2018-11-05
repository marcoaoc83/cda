<script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/select/1.1.2/js/dataTables.select.min.js"></script>
<script src="http://kingkode.com/datatables.editor.lite/js/altEditor/dataTables.altEditor.free.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        var tableParcela = $('#tbParcela').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            destroy: true,
            ajax: {
                "url": "{{ route('parcela.getdata') }}",
                "data": {
                    "PESSOAID": '{{$Pessoa->PESSOAID}}'
                }
            },
            columns: [
                {
                    data: 'SitPag',
                    name: 'SitPag'
                },
                {
                    data: 'SitCob',
                    name: 'SitCob'
                },
                {
                    data: 'OrigTrib',
                    name: 'OrigTrib'
                },
                {
                    data: 'Tributo',
                    name: 'Tributo'
                },
                {
                    data: 'LancamentoDt',
                    name: 'LancamentoDt'
                },
                {
                    data: 'ParcelaNr',
                    name: 'ParcelaNr'
                },
                {
                    data: 'PlanoQt',
                    name: 'PlanoQt'
                },
                {
                    data: 'VencimentoDt',
                    name: 'VencimentoDt'
                },
                {
                    data: 'PrincipalVr',
                    name: 'PrincipalVr'
                },
                {
                    data: 'MultaVr',
                    name: 'MultaVr'
                },
                {
                    data: 'JurosVr',
                    name: 'JurosVr'
                },
                {
                    data: 'TaxaVr',
                    name: 'TaxaVr'
                },
                {
                    data: 'AcrescimoVr',
                    name: 'AcrescimoVr'
                },
                {
                    data: 'DescontoVr',
                    name: 'DescontoVr'
                },
                {
                    data: 'Honorarios',
                    name: 'Honorarios'
                },
                {
                    data: 'TotalVr',
                    name: 'TotalVr'
                },
                {
                    data: 'SitPagId',
                    name: 'SitPagId',
                    "visible": false,
                    "searchable": false
                },
                {
                    data: 'SitCobId',
                    name: 'SitCobId',
                    "visible": false,
                    "searchable": false
                },
                {
                    data: 'OrigTribId',
                    name: 'OrigTribId',
                    "visible": false,
                    "searchable": false
                },
                {
                    data: 'TributoId',
                    name: 'TributoId',
                    "visible": false,
                    "searchable": false
                },
                {
                    data: 'ParcelaId',
                    name: 'ParcelaId',
                    "visible": false,
                    "searchable": false
                }
            ],
            select: {
                style: 'single',
                info: false

            },
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json"
            }
        });

        tableParcela.on( 'draw', function () {
            $('#pnParcela #btEditar').addClass('disabled');
            $('#pnParcela #btDeletar').addClass('disabled');
        } );

        tableParcela.on( 'select', function ( e, dt, type, indexes ) {
            if ( type === 'row' ) {
                var ParcelaId = tableParcela.rows( indexes ).data().pluck( 'ParcelaId' );
                $('#pnParcela #btEditar').removeClass('disabled');
                $('#pnParcela #btDeletar').removeClass('disabled');

                var tablePcRot = $('#tbPcRot').DataTable();
                var url = "{{ route('pcrot.getdata') }}"+"/?ParcelaId="+ParcelaId[0];
                tablePcRot.ajax.url(url).load( );

                var tbPcEvento = $('#tbPcEvento').DataTable();
                var url = "{{ route('pcevento.getdata') }}"+"/?ParcelaId="+ParcelaId[0];
                tbPcEvento.ajax.url(url).load( );
            }
        } )
            .on( 'deselect', function ( e, dt, type, indexes ) {
                $('#pnParcela #btEditar').addClass('disabled');
                $('#pnParcela #btDeletar').addClass('disabled');
            } );


        $('#formParcela').on('submit', function (e) {
            $.post( "{{ route('parcela.store') }}", $( "#formParcela" ).serialize() )
                .done(function( data ){
                    if (data){
                        $('#myModalParcela').modal('toggle');
                        swal({
                            position: 'top-end',
                            type: 'success',
                            title: 'Salvo com sucesso!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        tableParcela.ajax.reload();
                        $("#formParcela").trigger('reset');
                    }
                });
            return false;
        });
        $('#pnParcela #btDeletar').click(function () {
            var linha =tableParcela.row('.selected').data();
            var ParcelaId = linha[   'ParcelaId'];
            swal({
                title             : "Tem certeza?",
                text              : "Esta registro será deletado!",
                type              : "warning",
                showCancelButton  : true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText : "Sim",
                cancelButtonText  : "Não"
            }).then((resultado) => {
                if (resultado.value){
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        data: {
                            _token: '{!! csrf_token() !!}',
                            'ParcelaId': ParcelaId,
                            _method: 'DELETE'
                        },
                        url: '{{ url('admin/parcela/destroy') }}',
                        success: function (msg) {
                            $('#tbParcela').DataTable().ajax.reload();
                            swal({
                                position: 'top-end',
                                type: 'success',
                                title: 'Deletado com sucesso!',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        },
                        error: function (data) {
                            swal({
                                position: 'top-end',
                                type: 'error',
                                title: 'Erro ao deletar!',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }
                    });
                }
            });
        });

        $('#pnParcela #btEditar').click(function () {
            var linha =tableParcela.row('.selected').data();

            $('#pnParcela #formEditar #ParcelaId').val(linha['ParcelaId']);
            $('#pnParcela #formEditar #SitPagId').val(linha['SitPagId']);
            $('#pnParcela #formEditar #SitCobId').val(linha['SitCobId']);
            $('#pnParcela #formEditar #OrigTribId').val(linha['OrigTribId']);
            $('#pnParcela #formEditar #TributoId').val(linha['TributoId']);
            $('#pnParcela #formEditar #LancamentoDt').val(linha['LancamentoDt']);
            $('#pnParcela #formEditar #LancamentoNr').val(linha['LancamentoNr']);
            $('#pnParcela #formEditar #VencimentoDt').val(linha['VencimentoDt']);
            $('#pnParcela #formEditar #ParcelaNr').val(linha['ParcelaNr']);
            $('#pnParcela #formEditar #PlanoQt').val(linha['PlanoQt']);
            $('#pnParcela #formEditar #PrincipalVr').val(linha['PrincipalVr']);
            $('#pnParcela #formEditar #MultaVr').val(linha['MultaVr']);
            $('#pnParcela #formEditar #JurosVr').val(linha['JurosVr']);
            $('#pnParcela #formEditar #TaxaVr').val(linha['TaxaVr']);
            $('#pnParcela #formEditar #AcrescimoVr').val(linha['AcrescimoVr']);
            $('#pnParcela #formEditar #DescontoVr').val(linha['DescontoVr']);
            $('#pnParcela #formEditar #Honorarios').val(linha['Honorarios']);
            $('#pnParcela #formEditar #TotalVr').val(linha['TotalVr']);

        });

        $('#pnParcela #formEditar').on('submit', function (e) {
            var formData = $('#pnParcela #formEditar').serialize();

            $.ajax({
                dataType: 'json',
                type: 'POST',
                data:formData,
                url: '{{ url('admin/parcela/') }}'+'/' +$('#pnParcela #formEditar #ParcelaId').val(),
                success: function (data) {
                    if (data){
                        $('#myModalParcelaEdita').modal('toggle');
                        swal({
                            position: 'top-end',
                            type: 'success',
                            title: 'Editado com sucesso!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        tableParcela.ajax.reload();
                    }
            },
                error: function (retorno) {
                    $('#myModalParcelaEdita').modal('toggle');
                    console.log(retorno.responseJSON.message);
                    swal({
                        position: 'top-end',
                        type: 'error',
                        title: 'Erro!',
                        text: retorno.responseJSON.message,
                        showConfirmButton: false,
                        timer: 7500
                    });

                }
            });

            return false;
        });


    });
</script>

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
