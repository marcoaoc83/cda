<script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/select/1.1.2/js/dataTables.select.min.js"></script>
<script src="http://kingkode.com/datatables.editor.lite/js/altEditor/dataTables.altEditor.free.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        var tableSocResp = $('#tbSocResp').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            destroy: true,
            ajax: {
                "url": "{{ route('socresp.getdata') }}",
                "data": {
                    "PESSOAID": '{{$Pessoa->PESSOAID}}'
                }
            },
            columns: [
                {
                    data: 'CPF_CNPJNR',
                    name: 'CPF_CNPJNR'
                },
                {
                    data: 'PESSOANMRS',
                    name: 'PESSOANMRS'
                },

                {
                    data: 'InicioDt',
                    name: 'InicioDt'
                },
                {
                    data: 'TerminoDt',
                    name: 'TerminoDt'
                },
                {
                    data: 'PessoaIdSR',
                    name: 'PessoaIdSR',
                    "visible": false,
                    "searchable": false
                },
                {
                    data: 'SocRespId',
                    name: 'SocRespId',
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

        tableSocResp.on( 'draw', function () {
            $('#pnSocResp #btEditar').addClass('disabled');
            $('#pnSocResp #btDeletar').addClass('disabled');
        } );

        tableSocResp.on( 'select', function ( e, dt, type, indexes ) {
            if ( type === 'row' ) {
                $('#pnSocResp #btEditar').removeClass('disabled');
                $('#pnSocResp #btDeletar').removeClass('disabled');
            }
        } )
            .on( 'deselect', function ( e, dt, type, indexes ) {
                $('#pnSocResp #btEditar').addClass('disabled');
                $('#pnSocResp #btDeletar').addClass('disabled');
            } );


        $('#formSocResp').on('submit', function (e) {
            $.post( "{{ route('socresp.store') }}", $( "#formSocResp" ).serialize() )
                .done(function( data ){
                    if (data){
                        $('#myModalSocResp').modal('toggle');
                        swal({
                            position: 'top-end',
                            type: 'success',
                            title: 'Salvo com sucesso!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        tableSocResp.ajax.reload();
                        $("#formSocResp").trigger('reset');
                    }
                });
            return false;
        });
        $('#pnSocResp #btDeletar').click(function () {
            var linha =tableSocResp.row('.selected').data();
            var SocRespId = linha[   'SocRespId'];
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
                            'SocRespId': SocRespId,
                            _method: 'DELETE'
                        },
                        url: '{{ url('admin/socresp/destroy') }}',
                        success: function (msg) {
                            $('#tbSocResp').DataTable().ajax.reload();
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

        $('#pnSocResp #btEditar').click(function () {
            var linha =tableSocResp.row('.selected').data();

            $('#pnSocResp #formEditar #SocRespId').val(linha['SocRespId']);
            $('#pnSocResp #formEditar #PessoaIdSR').val(linha['PessoaIdSR']);
            $('#pnSocResp #formEditar #PessoaIdSRName').val(linha['PESSOANMRS']);
            $('#pnSocResp #formEditar #InicioDt').val(linha['InicioDt']);
            $('#pnSocResp #formEditar #TerminoDt').val(linha['TerminoDt']);


        });

        $('#pnSocResp #formEditar').on('submit', function (e) {
            var formData = $('#pnSocResp #formEditar').serialize();

            $.ajax({
                dataType: 'json',
                type: 'POST',
                data:formData,
                url: '{{ url('admin/socresp/') }}'+'/' +$('#pnSocResp #formEditar #SocRespId').val(),
                success: function (data) {
                    if (data){
                        $('#myModalSocRespEdita').modal('toggle');
                        swal({
                            position: 'top-end',
                            type: 'success',
                            title: 'Editado com sucesso!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        tableSocResp.ajax.reload();
                    }
            },
                error: function (retorno) {
                    $('#myModalSocRespEdita').modal('toggle');
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
