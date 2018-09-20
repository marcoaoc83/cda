<script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/select/1.1.2/js/dataTables.select.min.js"></script>
<script src="http://kingkode.com/datatables.editor.lite/js/altEditor/dataTables.altEditor.free.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        var tableInscrMun = $('#tbInscrMun').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            destroy: true,
            ajax: {
                "url": "{{ route('inscrmun.getdata') }}",
                "data": {
                    "PESSOAID": '{{$Pessoa->PESSOAID}}'
                }
            },
            columns: [

                {
                    data: 'INSCRMUNNR',
                    name: 'INSCRMUNNR'
                },
                {
                    data: 'REGTABNM',
                    name: 'REGTABNM'
                },
                {
                    data: 'INICIODT',
                    name: 'INICIODT'
                },
                {
                    data: 'TERMINODT',
                    name: 'TERMINODT'
                },
                {
                    data: 'SITUACAO',
                    name: 'SITUACAO',
                    render: function ( data, type, row ) {
                        if(data==1){
                            return "Ativo";
                        }else{
                            return "Cancelado";
                        }
                    }
                },
                {
                    data: 'INSCRMUNID',
                    name: 'INSCRMUNID',
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

        tableInscrMun.on( 'draw', function () {
            $('#pnInscrMun #btEditar').addClass('disabled');
            $('#pnInscrMun #btDeletar').addClass('disabled');
        } );

        tableInscrMun.on( 'select', function ( e, dt, type, indexes ) {
            if ( type === 'row' ) {
                $('#pnInscrMun #btEditar').removeClass('disabled');
                $('#pnInscrMun #btDeletar').removeClass('disabled');

                var INSCRMUNID = tableInscrMun.rows( indexes ).data().pluck( 'INSCRMUNID' );
                var tablePsCanal = $('#tbPsCanal').DataTable();
                var url = "{{ route('pscanal.getdata') }}"+"/?INSCRMUNID="+INSCRMUNID[0];
                tablePsCanal.ajax.url(url).load( );
                $('#formPsCanal #InscrMunId').val(INSCRMUNID[0]);
                $('#myModalPsCanalEdita #InscrMunId').val(INSCRMUNID[0]);
                $('#pnPsCanal #btInserir').removeClass('disabled');

                var tableSocResp = $('#tbSocResp').DataTable();
                var url = "{{ route('socresp.getdata') }}"+"/?INSCRMUNID="+INSCRMUNID[0];
                tableSocResp.ajax.url(url).load( );
                $('#formSocResp #InscrMunId').val(INSCRMUNID[0]);
                $('#myModalSocRespEdita #InscrMunId').val(INSCRMUNID[0]);
                $('#pnSocResp #btInserir').removeClass('disabled');

                var tableAtiveCom = $('#tbAtiveCom').DataTable();
                var url = "{{ route('ativecon.getdata') }}"+"/?INSCRMUNID="+INSCRMUNID[0];
                tableAtiveCom.ajax.url(url).load( );
                $('#formAtiveCom #InscrMunId').val(INSCRMUNID[0]);
                $('#myModalAtiveComEdita #InscrMunId').val(INSCRMUNID[0]);
                $('#pnAtiveCom #btInserir').removeClass('disabled');

                var tableCredPort = $('#tbCredPort').DataTable();
                var url = "{{ route('credport.getdata') }}"+"/?INSCRMUNID="+INSCRMUNID[0];
                tableCredPort.ajax.url(url).load( );
                $('#formCredPort #InscrMunId').val(INSCRMUNID[0]);
                $('#myModalCredPortEdita #InscrMunId').val(INSCRMUNID[0]);
                $('#pnCredPort #btInserir').removeClass('disabled');

                var tableParcela = $('#tbParcela').DataTable();
                var url = "{{ route('parcela.getdata') }}"+"/?INSCRMUNID="+INSCRMUNID[0];
                tableParcela.ajax.url(url).load( );
                $('#formParcela #InscrMunId').val(INSCRMUNID[0]);
                $('#myModalParcelaEdita #InscrMunId').val(INSCRMUNID[0]);
                $('#pnParcela #btInserir').removeClass('disabled');
            }
        } )
            .on( 'deselect', function ( e, dt, type, indexes ) {

                var tableParcela = $('#tbParcela').DataTable();
                var url = "{{ route('parcela.getdata') }}";
                tableParcela.ajax.url(url).load( );
                var tablePsCanal = $('#tbPsCanal').DataTable();
                var url = "{{ route('pscanal.getdata') }}";
                tablePsCanal.ajax.url(url).load( );
                var tableSocResp = $('#tbSocResp').DataTable();
                var url = "{{ route('socresp.getdata') }}";
                tableSocResp.ajax.url(url).load( );
                var tableAtiveCom = $('#tbAtiveCom').DataTable();
                var url = "{{ route('ativecon.getdata') }}";
                tableAtiveCom.ajax.url(url).load( );

                $('#pnInscrMun #btEditar').addClass('disabled');
                $('#pnInscrMun #btDeletar').addClass('disabled');

                $('#pnPsCanal #btEditar').addClass('disabled');
                $('#pnPsCanal #btDeletar').addClass('disabled');
                $('#pnPsCanal #btInserir').addClass('disabled');

                $('#pnSocResp #btEditar').addClass('disabled');
                $('#pnSocResp #btDeletar').addClass('disabled');
                $('#pnSocResp #btInserir').addClass('disabled');

                $('#pnAtiveCom #btEditar').addClass('disabled');
                $('#pnAtiveCom #btDeletar').addClass('disabled');
                $('#pnAtiveCom #btInserir').addClass('disabled');

                $('#pnCredPort #btEditar').addClass('disabled');
                $('#pnCredPort #btDeletar').addClass('disabled');
                $('#pnCredPort #btInserir').addClass('disabled');

                $('#pnParcela #btEditar').addClass('disabled');
                $('#pnParcela #btDeletar').addClass('disabled');
                $('#pnParcela #btInserir').addClass('disabled');
            } );


        $('#formInscrMun').on('submit', function (e) {
            $.post( "{{ route('inscrmun.store') }}", $( "#formInscrMun" ).serialize() )
                .done(function( data ){
                    if (data){
                        $('#myModalInscrMun').modal('toggle');
                        swal({
                            position: 'top-end',
                            type: 'success',
                            title: 'Salvo com sucesso!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        tableInscrMun.ajax.reload();
                    }
                });
            return false;
        });
        $('#pnInscrMun #btDeletar').click(function () {
            var linha =tableInscrMun.row('.selected').data();
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
                        url: '{{ url('admin/inscrmun/destroy') }}',
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

        $('#pnInscrMun #btEditar').click(function () {
            var linha =tableInscrMun.row('.selected').data();

            var INSCRMUNID = linha['INSCRMUNID'];
            var INSCRMUNNR = linha['INSCRMUNNR'];
            var ORIGTRIBID = linha['ORIGTRIBID'];
            var INICIODT = linha['INICIODT'];
            var TERMINODT = linha['TERMINODT'];
            var SITUACAO = linha['SITUACAO'];

            $('#pnInscrMun #formEditar #INSCRMUNID').val(INSCRMUNID);
            $('#pnInscrMun #formEditar #INSCRMUNNR').val(INSCRMUNNR);
            $('#pnInscrMun #formEditar #ORIGTRIBID').val(ORIGTRIBID);
            $('#pnInscrMun #formEditar #INICIODT').val(INICIODT);
            $('#pnInscrMun #formEditar #TERMINODT').val(TERMINODT);
            $('#pnInscrMun #formEditar #SITUACAO').val(SITUACAO);
            var ativo=false;
            if(SITUACAO==1) ativo=true;

            if($( '#pnInscrMun #formEditar #SITUACAO' ).prop("checked") !=ativo){
                $( '#pnInscrMun #formEditar #SITUACAO' ).trigger("click");
            }

        });

        $('#pnInscrMun #formEditar').on('submit', function (e) {
            var formData = $('#pnInscrMun #formEditar').serialize();

            $.ajax({
                dataType: 'json',
                type: 'POST',
                data:formData,
                url: '{{ url('admin/inscrmun/') }}'+'/' +$('#pnInscrMun #formEditar #INSCRMUNID').val(),
                success: function (data) {
                    if (data){
                        $('#myModalInscrMunEdita').modal('toggle');
                        swal({
                            position: 'top-end',
                            type: 'success',
                            title: 'Editado com sucesso!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        tableInscrMun.ajax.reload();
                    }
            },
                error: function (retorno) {
                    $('#myModalInscrMunEdita').modal('toggle');
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
