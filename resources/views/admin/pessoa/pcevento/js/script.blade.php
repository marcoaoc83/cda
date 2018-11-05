<script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/select/1.1.2/js/dataTables.select.min.js"></script>
<script src="http://kingkode.com/datatables.editor.lite/js/altEditor/dataTables.altEditor.free.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        var tablePcEvento = $('#tbPcEvento').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            destroy: true,
            ajax: {
                "url": "{{ route('pcrot.getdata') }}"
            },
            columns: [
                {
                    data: 'EVENTODT',
                    name: 'EVENTODT'
                },
                {
                    data: 'Objetivo',
                    name: 'Objetivo'
                },
                {
                    data: 'Evento',
                    name: 'Evento'
                },
                {
                    data: 'Fila',
                    name: 'Fila'
                },
                {
                    data: 'Fonte',
                    name: 'Fonte'
                },
                {
                    data: 'Canal',
                    name: 'Canal'
                },
                {
                    data: 'Tipo',
                    name: 'Tipo'
                }
            ],
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json"
            }
        });

        tablePcEvento.on( 'draw', function () {
            $('#pnPcEvento #btEditar').addClass('disabled');
            $('#pnPcEvento #btDeletar').addClass('disabled');
        } );

        tablePcEvento.on( 'select', function ( e, dt, type, indexes ) {
            if ( type === 'row' ) {
                $('#pnPcEvento #btEditar').removeClass('disabled');
                $('#pnPcEvento #btDeletar').removeClass('disabled');
            }
        } )
            .on( 'deselect', function ( e, dt, type, indexes ) {
                $('#pnPcEvento #btEditar').addClass('disabled');
                $('#pnPcEvento #btDeletar').addClass('disabled');
            } );


        $('#formPcEvento').on('submit', function (e) {
            $.post( "{{ route('pcevento.store') }}", $( "#formPcEvento" ).serialize() )
                .done(function( data ){
                    if (data){
                        $('#myModalPcEvento').modal('toggle');
                        swal({
                            position: 'top-end',
                            type: 'success',
                            title: 'Salvo com sucesso!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        tablePcEvento.ajax.reload();
                    }
                });
            return false;
        });
        $('#pnPcEvento #btDeletar').click(function () {
            var linha =tablePcEvento.row('.selected').data();
            var INSCRMUNID = linha[   'INSCRMUNID'];
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
                            'INSCRMUNID': INSCRMUNID,
                            _method: 'DELETE'
                        },
                        url: '{{ url('admin/pcevento/destroy') }}',
                        success: function (msg) {
                            $('.datatable').DataTable().ajax.reload();
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

        $('#pnPcEvento #btEditar').click(function () {
            var linha =tablePcEvento.row('.selected').data();

            var INSCRMUNID = linha['INSCRMUNID'];
            var INSCRMUNNR = linha['INSCRMUNNR'];
            var ORIGTRIBID = linha['ORIGTRIBID'];
            var INICIODT = linha['INICIODT'];
            var TERMINODT = linha['TERMINODT'];
            var SITUACAO = linha['SITUACAO'];

            $('#pnPcEvento #formEditar #INSCRMUNID').val(INSCRMUNID);
            $('#pnPcEvento #formEditar #INSCRMUNNR').val(INSCRMUNNR);
            $('#pnPcEvento #formEditar #ORIGTRIBID').val(ORIGTRIBID);
            $('#pnPcEvento #formEditar #INICIODT').val(INICIODT);
            $('#pnPcEvento #formEditar #TERMINODT').val(TERMINODT);
            $('#pnPcEvento #formEditar #SITUACAO').val(SITUACAO);
            var ativo=false;
            if(SITUACAO==1) ativo=true;

            if($( '#pnPcEvento #formEditar #SITUACAO' ).prop("checked") !=ativo){
                $( '#pnPcEvento #formEditar #SITUACAO' ).trigger("click");
            }

        });

        $('#pnPcEvento #formEditar').on('submit', function (e) {
            var formData = $('#pnPcEvento #formEditar').serialize();

            $.ajax({
                dataType: 'json',
                type: 'POST',
                data:formData,
                url: '{{ url('admin/pcevento/') }}'+'/' +$('#pnPcEvento #formEditar #INSCRMUNID').val(),
                success: function (data) {
                    if (data){
                        $('#myModalPcEventoEdita').modal('toggle');
                        swal({
                            position: 'top-end',
                            type: 'success',
                            title: 'Editado com sucesso!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        tablePcEvento.ajax.reload();
                    }
            },
                error: function (retorno) {
                    $('#myModalPcEventoEdita').modal('toggle');
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
