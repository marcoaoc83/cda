<script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/select/1.1.2/js/dataTables.select.min.js"></script>
<script src="http://kingkode.com/datatables.editor.lite/js/altEditor/dataTables.altEditor.free.js"></script>
<script type="text/javascript">
    function buscacep(cep,form) {
        $.ajax({
            method: "POST",
            url: "{{route('portal.cep')}}",
            data: { cep: cep, _token: '{!! csrf_token() !!}'}
        })
            .done(function( msg ) {
                var obj = $.parseJSON( msg);
                $('#'+form+' #Logradouro').val(obj.logradouro);
                $('#'+form+' #Bairro').val(obj.bairro);
                $('#'+form+' #Cidade').val(obj.localidade);
                $('#'+form+' #UF').val(obj.uf);
            });
    }

    function selectCanal(canal,form){
        $.ajax({
            type: 'GET',
            dataType: 'json',
            data: {
                _token: '{!! csrf_token() !!}',
                canal: canal
            },
            url: "{!! url('admin/pessoa/canal') !!}",
            success: function( result ) {
                if(result.oEMAIL==1){
                    $('#'+form+' #Email').attr('required','required');
                    $('#'+form+' #Email').attr('readonly', false);
                    $('#'+form+' #Email').parents( ".item" ).show();
                }else{
                    $('#'+form+' #Email').attr('readonly', true);
                    $('#'+form+' #Email').removeAttr('required');
                    $('#'+form+' #Email').parents( ".item" ).hide();
                }
                if(result.oTELEFONE==1){
                    $('#'+form+' #TelefoneNr').attr('required','required');
                    $('#'+form+' #TelefoneNr').attr('readonly', false);
                    $('#'+form+' #TelefoneNr').parents( ".item" ).show();
                }else{
                    $('#'+form+' #TelefoneNr').removeAttr('required');
                    $('#'+form+' #TelefoneNr').attr('readonly', true);
                    $('#'+form+' #TelefoneNr').parents( ".item" ).hide();
                }
                if(result.oCEP==1){
                    $('#'+form+' #CEP').attr('required','required');
                    $('#'+form+' #CEP').attr('readonly', false);
                    $('#'+form+' #CEP').parents( ".item" ).show();
                }else{
                    $('#'+form+' #CEP').removeAttr('required');
                    $('#'+form+' #CEP').attr('readonly', true);
                    $('#'+form+' #CEP').parents( ".item" ).hide();
                }
                if(result.oNUMERO==1){
                    $('#'+form+' #EnderecoNr').attr('required','required');
                    $('#'+form+' #EnderecoNr').attr('readonly', false);
                    $('#'+form+' #EnderecoNr').parents( ".item" ).show();
                }else{
                    $('#'+form+' #EnderecoNr').removeAttr('required');
                    $('#'+form+' #EnderecoNr').attr('readonly', true);
                    $('#'+form+' #EnderecoNr').parents( ".item" ).hide();
                }
                if(result.oLOGRADOURO==1){
                    $('#'+form+' #Logradouro').attr('required','required');
                    $('#'+form+' #Logradouro').attr('readonly', false);
                    $('#'+form+' #Logradouro').parents( ".item" ).show();
                }else{
                    $('#'+form+' #Logradouro').removeAttr('required');
                    $('#'+form+' #Logradouro').attr('readonly', true);
                    $('#'+form+' #Logradouro').parents( ".item" ).hide();
                }
                if(result.oCOMPLEMENTO==1){
                    $('#'+form+' #Complemento').attr('required','required');
                    $('#'+form+' #Complemento').attr('readonly', false);
                    $('#'+form+' #Complemento').parents( ".item" ).show();
                }else{
                    $('#'+form+' #Complemento').removeAttr('required');
                    $('#'+form+' #Complemento').attr('readonly', true);
                    $('#'+form+' #Complemento').parents( ".item" ).hide();
                }
                if(result.oBAIRRO==1){
                    $('#'+form+' #Bairro').attr('required','required');
                    $('#'+form+' #Bairro').attr('readonly', false);
                    $('#'+form+' #Bairro').parents( ".item" ).show();
                }else{
                    $('#'+form+' #Bairro').removeAttr('required');
                    $('#'+form+' #Bairro').attr('readonly', true);
                    $('#'+form+' #Bairro').parents( ".item" ).hide();
                }
                if(result.oCIDADE==1){
                    $('#'+form+' #Cidade').attr('required','required');
                    $('#'+form+' #Cidade').attr('readonly', false);
                    $('#'+form+' #Cidade').parents( ".item" ).show();
                }else{
                    $('#'+form+' #Cidade').removeAttr('required');
                    $('#'+form+' #Cidade').attr('readonly', true);
                    $('#'+form+' #Cidade').parents( ".item" ).hide();
                }
                if(result.oUF==1){
                    $('#'+form+' #UF').attr('required','required');
                    $('#'+form+' #UF').attr('readonly', false);
                    $('#'+form+' #UF').parents( ".item" ).show();
                }else{
                    $('#'+form+' #UF').removeAttr('required');
                    $('#'+form+' #UF').attr('readonly', true);
                    $('#'+form+' #UF').parents( ".item" ).hide();
                }
            }
        });
    }
    $(document).ready(function() {

        var tablePsCanal = $('#tbPsCanal').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            destroy: true,
            ajax: {
                "url": "{{ route('pscanal.getdata') }}",
                "data": {
                    "PESSOAID": '{{$Pessoa->PESSOAID}}'
                }
            },
            columns: [

                {
                    data: 'FonteInfo',
                    name: 'FonteInfo'
                },
                {
                    data: 'CANALSG',
                    name: 'CANALSG'
                },
                {
                    data: 'TipPos',
                    name: 'TipPos'
                },
                {
                    data: 'TelefoneNr',
                    name: 'TelefoneNr'
                },
                {
                    data: 'Email',
                    name: 'Email'
                },
                {
                    data: 'CEP',
                    name: 'CEP'
                },
                {
                    data: 'Logradouro',
                    name: 'Logradouro'
                },
                {
                    data: 'EnderecoNr',
                    name: 'EnderecoNr'
                },
                {
                    data: 'Complemento',
                    name: 'Complemento'
                },
                {
                    data: 'Bairro',
                    name: 'Bairro'
                },
                {
                    data: 'Cidade',
                    name: 'Cidade'
                },
                {
                    data: 'UF',
                    name: 'UF'
                },

                {
                    data: 'PsCanalId',
                    name: 'PsCanalId',
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

        tablePsCanal.on( 'draw', function () {
            $('#pnPsCanal #btEditar').addClass('disabled');
            $('#pnPsCanal #btDeletar').addClass('disabled');
        } );

        tablePsCanal.on( 'select', function ( e, dt, type, indexes ) {
            if ( type === 'row' ) {
                $('#pnPsCanal #btEditar').removeClass('disabled');
                $('#pnPsCanal #btDeletar').removeClass('disabled');

                var PsCanalId = tablePsCanal.rows( indexes ).data().pluck( 'PsCanalId' );
                var tbPsCanalEvento = $('#tbPsCanalEvento').DataTable();
                var url = "{{ route('pscanalevento.getdata') }}"+"/?pscanal="+PsCanalId[0];
                tbPsCanalEvento.ajax.url(url).load( );
            }
        } )
            .on( 'deselect', function ( e, dt, type, indexes ) {
                $('#pnPsCanal #btEditar').addClass('disabled');
                $('#pnPsCanal #btDeletar').addClass('disabled');
            } );


        $('#formPsCanal').on('submit', function (e) {
            $.post( "{{ route('pscanal.store') }}", $( "#formPsCanal" ).serialize() )
                .done(function( data ){
                    if (data){
                        $('#myModalPsCanal').modal('toggle');
                        swal({
                            position: 'top-end',
                            type: 'success',
                            title: 'Salvo com sucesso!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        tablePsCanal.ajax.reload();
                        $("#formPsCanal").trigger('reset');
                    }
                });
            return false;
        });
        $('#pnPsCanal #btDeletar').click(function () {
            var linha =tablePsCanal.row('.selected').data();
            var PsCanalId = linha[   'PsCanalId'];
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
                            'PsCanalId': PsCanalId,
                            _method: 'DELETE'
                        },
                        url: '{{ url('admin/pscanal/destroy') }}',
                        success: function (msg) {
                            $('#tbPsCanal').DataTable().ajax.reload();
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

        $('#pnPsCanal #btEditar').click(function () {
            var linha =tablePsCanal.row('.selected').data();

            $('#pnPsCanal #formEditar #PsCanalId').val(linha['PsCanalId']);
            $('#pnPsCanal #formEditar #FonteInfoId').val(linha['FonteInfoId']);
            $('#pnPsCanal #formEditar #CanalId').val(linha['CanalId']);
            $('#pnPsCanal #formEditar #TipPosId').val(linha['TipPosId']);
            $('#pnPsCanal #formEditar #CEP').val(linha['CEP']);
            $('#pnPsCanal #formEditar #Logradouro').val(linha['Logradouro']);
            $('#pnPsCanal #formEditar #EnderecoNr').val(linha['EnderecoNr']);
            $('#pnPsCanal #formEditar #Complemento').val(linha['Complemento']);
            $('#pnPsCanal #formEditar #TelefoneNr').val(linha['TelefoneNr']);
            $('#pnPsCanal #formEditar #Email').val(linha['Email']);
            $('#pnPsCanal #formEditar #LogradouroDesc').val(linha['LogradouroDesc']);
            $('#pnPsCanal #formEditar #Bairro').val(linha['Bairro']);
            $('#pnPsCanal #formEditar #Cidade').val(linha['Cidade']);
            $('#pnPsCanal #formEditar #UF').val(linha['UF']);
            $('#pnPsCanal #formEditar #InscrMunId').val(linha['InscrMunId']);
            selectCanal(linha['CanalId'],'formEditar');

        });

        $('#pnPsCanal #formEditar').on('submit', function (e) {
            var formData = $('#pnPsCanal #formEditar').serialize();

            $.ajax({
                dataType: 'json',
                type: 'POST',
                data:formData,
                url: '{{ url('admin/pscanal/') }}'+'/' +$('#pnPsCanal #formEditar #PsCanalId').val(),
                success: function (data) {
                    if (data){
                        $('#myModalPsCanalEdita').modal('toggle');
                        swal({
                            position: 'top-end',
                            type: 'success',
                            title: 'Editado com sucesso!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        tablePsCanal.ajax.reload();
                    }
            },
                error: function (retorno) {
                    $('#myModalPsCanalEdita').modal('toggle');
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
