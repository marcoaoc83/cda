<script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/select/1.1.2/js/dataTables.select.min.js"></script>
<script src="http://kingkode.com/datatables.editor.lite/js/altEditor/dataTables.altEditor.free.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        var tableModeloVar = $('#tbModeloVar').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            destroy: true,
            ajax: {
                "url": "{{ route('modelovar.getdata') }}",
                "data": {
                    "ModComId": '{{$modelo->ModComId}}'
                }
            },
            columns: [

                {
                    data: 'var_codigo',
                    name: 'var_codigo'
                },
                {
                    data: 'var_valor',
                    name: 'var_valor'
                },
                {
                    data: 'var_id',
                    name: 'var_id',
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

        tableModeloVar.on( 'draw', function () {
            $('#pnModeloVar #btEditar').addClass('disabled');
            $('#pnModeloVar #btDeletar').addClass('disabled');
        } );

        tableModeloVar.on( 'select', function ( e, dt, type, indexes ) {
            if ( type === 'row' ) {
                $('#pnModeloVar #btEditar').removeClass('disabled');
                $('#pnModeloVar #btDeletar').removeClass('disabled');

            }
        } )
            .on( 'deselect', function ( e, dt, type, indexes ) {
                $('#pnModeloVar #btEditar').addClass('disabled');
                $('#pnModeloVar #btDeletar').addClass('disabled');
            } );


        $('#formModeloVar').on('submit', function (e) {
            $.post( "{{ route('modelovar.store') }}", $( "#formModeloVar" ).serialize() )
                .done(function( data ){
                    if (data){
                        $('#myModalModeloVar').modal('toggle');
                        swal({
                            position: 'top-end',
                            type: 'success',
                            title: 'Salvo com sucesso!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        tableModeloVar.ajax.reload();
                    }
                });
            return false;
        });
        $('#pnModeloVar #btDeletar').click(function () {
            var linha =tableModeloVar.row('.selected').data();
            var var_id = linha[   'var_id'];
            swal({
                title             : "Tem certeza?",
                text              : "Este registro será deletado!",
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
                            'var_id': var_id,
                            _method: 'DELETE'
                        },
                        url: '{{ url('admin/modelovar/destroy') }}',
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

        $('#pnModeloVar #btEditar').click(function () {
            var linha =tableModeloVar.row('.selected').data();

            var var_titulo = linha['var_titulo'];
            var var_codigo = linha['var_codigo'];
            var var_tabela = linha['var_tabela'];
            var var_campo = linha['var_campo'];
            var var_tipo = linha['var_tipo'];
            var var_id = linha['var_id'];

            $('#pnModeloVar #formEditar #var_titulo').val(var_titulo);
            $('#pnModeloVar #formEditar #var_codigo').val(var_codigo);
            $('#pnModeloVar #formEditar #var_tabela').val(var_tabela);
            $('#pnModeloVar #formEditar #var_campo').val(var_campo);
            $('#pnModeloVar #formEditar #var_tipo').val(var_tipo);
            $('#pnModeloVar #formEditar #var_id').val(var_id);

        });

        $('#pnModeloVar #formEditar').on('submit', function (e) {
            var formData = $('#pnModeloVar #formEditar').serialize();

            $.ajax({
                dataType: 'json',
                type: 'POST',
                data:formData,
                url: '{{ url('admin/modelovar/') }}'+'/' +$('#pnModeloVar #formEditar #var_id').val(),
                success: function (data) {
                    if (data){
                        $('#myModalModeloVarEdita').modal('toggle');
                        swal({
                            position: 'top-end',
                            type: 'success',
                            title: 'Editado com sucesso!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        tableModeloVar.ajax.reload();
                    }
            },
                error: function (retorno) {
                    $('#myModalModeloVarEdita').modal('toggle');
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
