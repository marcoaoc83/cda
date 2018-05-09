<script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/select/1.1.2/js/dataTables.select.min.js"></script>
<script src="http://kingkode.com/datatables.editor.lite/js/altEditor/dataTables.altEditor.free.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        var tableAtivCom = $('#tbAtivCom').DataTable({

            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json"
            }
        });

        tableAtivCom.on( 'draw', function () {
            $('#pnAtivCom #btEditar').addClass('disabled');
            $('#pnAtivCom #btDeletar').addClass('disabled');
        } );

        tableAtivCom.on( 'select', function ( e, dt, type, indexes ) {
            if ( type === 'row' ) {
                $('#pnAtivCom #btEditar').removeClass('disabled');
                $('#pnAtivCom #btDeletar').removeClass('disabled');
            }
        } )
            .on( 'deselect', function ( e, dt, type, indexes ) {
                $('#pnAtivCom #btEditar').addClass('disabled');
                $('#pnAtivCom #btDeletar').addClass('disabled');
            } );


        $('#formAtivCom').on('submit', function (e) {
            $.post( "{{ route('ativecon.store') }}", $( "#formAtivCom" ).serialize() )
                .done(function( data ){
                    if (data){
                        $('#myModalAtivCom').modal('toggle');
                        swal({
                            position: 'top-end',
                            type: 'success',
                            title: 'Salvo com sucesso!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        tableAtivCom.ajax.reload();
                    }
                });
            return false;
        });
        $('#pnAtivCom #btDeletar').click(function () {
            var linha =tableAtivCom.row('.selected').data();
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
                        url: '{{ url('admin/ativecon/destroy') }}',
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

        $('#pnAtivCom #btEditar').click(function () {
            var linha =tableAtivCom.row('.selected').data();

            var INSCRMUNID = linha['INSCRMUNID'];
            var INSCRMUNNR = linha['INSCRMUNNR'];
            var ORIGTRIBID = linha['ORIGTRIBID'];
            var INICIODT = linha['INICIODT'];
            var TERMINODT = linha['TERMINODT'];
            var SITUACAO = linha['SITUACAO'];

            $('#pnAtivCom #formEditar #INSCRMUNID').val(INSCRMUNID);
            $('#pnAtivCom #formEditar #INSCRMUNNR').val(INSCRMUNNR);
            $('#pnAtivCom #formEditar #ORIGTRIBID').val(ORIGTRIBID);
            $('#pnAtivCom #formEditar #INICIODT').val(INICIODT);
            $('#pnAtivCom #formEditar #TERMINODT').val(TERMINODT);
            $('#pnAtivCom #formEditar #SITUACAO').val(SITUACAO);
            var ativo=false;
            if(SITUACAO==1) ativo=true;

            if($( '#pnAtivCom #formEditar #SITUACAO' ).prop("checked") !=ativo){
                $( '#pnAtivCom #formEditar #SITUACAO' ).trigger("click");
            }

        });

        $('#pnAtivCom #formEditar').on('submit', function (e) {
            var formData = $('#pnAtivCom #formEditar').serialize();

            $.ajax({
                dataType: 'json',
                type: 'POST',
                data:formData,
                url: '{{ url('admin/ativecon/') }}'+'/' +$('#pnAtivCom #formEditar #INSCRMUNID').val(),
                success: function (data) {
                    if (data){
                        $('#myModalAtivComEdita').modal('toggle');
                        swal({
                            position: 'top-end',
                            type: 'success',
                            title: 'Editado com sucesso!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        tableAtivCom.ajax.reload();
                    }
            },
                error: function (retorno) {
                    $('#myModalAtivComEdita').modal('toggle');
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
