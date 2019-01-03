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
    function selectCanalForm(canal,form){
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
                }else{
                    $('#'+form+' #Email').attr('readonly', true);
                    $('#'+form+' #Email').removeAttr('required');
                }
                if(result.oTELEFONE==1){
                    $('#'+form+' #TelefoneNr').attr('required','required');
                    $('#'+form+' #TelefoneNr').attr('readonly', false);
                }else{
                    $('#'+form+' #TelefoneNr').removeAttr('required');
                    $('#'+form+' #TelefoneNr').attr('readonly', true);
                }
                if(result.oCEP==1){
                    $('#'+form+' #CEP').attr('required','required');
                    $('#'+form+' #CEP').attr('readonly', false);
                }else{
                    $('#'+form+' #CEP').removeAttr('required');
                    $('#'+form+' #CEP').attr('readonly', true);
                }
                if(result.oNUMERO==1){
                    $('#'+form+' #EnderecoNr').attr('required','required');
                    $('#'+form+' #EnderecoNr').attr('readonly', false);
                }else{
                    $('#'+form+' #EnderecoNr').removeAttr('required');
                    $('#'+form+' #EnderecoNr').attr('readonly', true);
                }
                if(result.oLOGRADOURO==1){
                    $('#'+form+' #Logradouro').attr('required','required');
                    $('#'+form+' #Logradouro').attr('readonly', false);
                }else{
                    $('#'+form+' #Logradouro').removeAttr('required');
                    $('#'+form+' #Logradouro').attr('readonly', true);
                }
                if(result.oCOMPLEMENTO==1){
                    $('#'+form+' #Complemento').attr('required','required');
                    $('#'+form+' #Complemento').attr('readonly', false);
                }else{
                    $('#'+form+' #Complemento').removeAttr('required');
                    $('#'+form+' #Complemento').attr('readonly', true);
                }
                if(result.oBAIRRO==1){
                    $('#'+form+' #Bairro').attr('required','required');
                    $('#'+form+' #Bairro').attr('readonly', false);
                }else{
                    $('#'+form+' #Bairro').removeAttr('required');
                    $('#'+form+' #Bairro').attr('readonly', true);
                }
                if(result.oCIDADE==1){
                    $('#'+form+' #Cidade').attr('required','required');
                    $('#'+form+' #Cidade').attr('readonly', false);
                }else{
                    $('#'+form+' #Cidade').removeAttr('required');
                    $('#'+form+' #Cidade').attr('readonly', true);
                }
                if(result.oUF==1){
                    $('#'+form+' #UF').attr('required','required');
                    $('#'+form+' #UF').attr('readonly', false);
                }else{
                    $('#'+form+' #UF').removeAttr('required');
                    $('#'+form+' #UF').attr('readonly', true);
                }
            }
        });
    }
function abreNovoCanal(pessoa) {
    $('#myModalPsCanal').modal('show');
    $('#formPsCanal #PessoaId').val(pessoa);
}

function abreEditaCanal(pessoa,canal) {
    $('#myModalPsCanalEdita').modal('show');
    $('#formEditar #PessoaId').val(pessoa);
    $('#formEditar #PsCanalId').val(canal);

    $.ajax({
        dataType: 'json',
        type: 'GET',
        url: '{{ url('admin/pscanal/') }}' + '/' + canal,
        success: function (linha) {
            if (linha) {
                $('#formEditar #FonteInfoId').val(linha.FonteInfoId);
                $('#formEditar #CanalId').val(linha.CanalId);
                $('#formEditar #TipPosId').val(linha.TipPosId);
                $('#formEditar #CEP').val(linha.CEP);
                $('#formEditar #Logradouro').val(linha.Logradouro);
                $('#formEditar #EnderecoNr').val(linha.EnderecoNr);
                $('#formEditar #Complemento').val(linha.Complemento);
                $('#formEditar #TelefoneNr').val(linha.TelefoneNr);
                $('#formEditar #Email').val(linha.Email);
                $('#formEditar #LogradouroDesc').val(linha.LogradouroDesc);
                $('#formEditar #Bairro').val(linha.Bairro);
                $('#formEditar #Cidade').val(linha.Cidade);
                $('#formEditar #UF').val(linha.UF);
                $.ajax({
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        _token: '{!! csrf_token() !!}',
                        canal: linha.CanalId
                    },
                    url: "{!! url('admin/pessoa/canal') !!}",
                    success: function( result ) {
                        if(result.oEMAIL==1){
                            $('#formEditar #Email').attr('required','required');
                            $('#formEditar #Email').attr('readonly', false);
                        }else{
                            $('#formEditar #Email').attr('readonly', true);
                            $('#formEditar #Email').removeAttr('required');
                        }
                        if(result.oTELEFONE==1){
                            $('#formEditar #TelefoneNr').attr('required','required');
                            $('#formEditar #TelefoneNr').attr('readonly', false);
                        }else{
                            $('#formEditar #TelefoneNr').removeAttr('required');
                            $('#formEditar #TelefoneNr').attr('readonly', true);
                        }
                        if(result.oCEP==1){
                            $('#formEditar #CEP').attr('required','required');
                            $('#formEditar #CEP').attr('readonly', false);
                        }else{
                            $('#formEditar #CEP').removeAttr('required');
                            $('#formEditar #CEP').attr('readonly', true);
                        }
                        if(result.oNUMERO==1){
                            $('#formEditar #EnderecoNr').attr('required','required');
                            $('#formEditar #EnderecoNr').attr('readonly', false);
                        }else{
                            $('#formEditar #EnderecoNr').removeAttr('required');
                            $('#formEditar #EnderecoNr').attr('readonly', true);
                        }
                        if(result.oLOGRADOURO==1){
                            $('#formEditar #Logradouro').attr('required','required');
                            $('#formEditar #Logradouro').attr('readonly', false);
                        }else{
                            $('#formEditar #Logradouro').removeAttr('required');
                            $('#formEditar #Logradouro').attr('readonly', true);
                        }
                        if(result.oCOMPLEMENTO==1){
                            $('#formEditar #Complemento').attr('required','required');
                            $('#formEditar #Complemento').attr('readonly', false);
                        }else{
                            $('#formEditar #Complemento').removeAttr('required');
                            $('#formEditar #Complemento').attr('readonly', true);
                        }
                        if(result.oBAIRRO==1){
                            $('#formEditar #Bairro').attr('required','required');
                            $('#formEditar #Bairro').attr('readonly', false);
                        }else{
                            $('#formEditar #Bairro').removeAttr('required');
                            $('#formEditar #Bairro').attr('readonly', true);
                        }
                        if(result.oCIDADE==1){
                            $('#formEditar #Cidade').attr('required','required');
                            $('#formEditar #Cidade').attr('readonly', false);
                        }else{
                            $('#formEditar #Cidade').removeAttr('required');
                            $('#formEditar #Cidade').attr('readonly', true);
                        }
                        if(result.oUF==1){
                            $('#formEditar #UF').attr('required','required');
                            $('#formEditar #UF').attr('readonly', false);
                        }else{
                            $('#formEditar #UF').removeAttr('required');
                            $('#formEditar #UF').attr('readonly', true);
                        }
                    }
                });
            }
        }
    });




}

function addRoteiro(obj) {
    console.log(obj);
    if ( $( "#roteirosId"+obj.value ).length ) {
        $( "#roteirosId"+obj.value ).remove();
    }else{
        $('#formFiltroParcela').append('<input type="hidden" id="roteirosId'+obj.value+'" name="roteirosId[]" value='+obj.value+' />');
    }

}

function filtrarParcelas(){
    $("#divResultValidacaoRes").hide();
    $("#divResultContribuinteRes").show();
    $("#divResultIM").hide();
    $("#divResultParcela").show();
    var tbContribuinteRes = $('#tbContribuinteRes').DataTable();
    var url = "{{ route('execfila.getdataParcela') }}"+"/?group=Pes&"+$('#formFiltroParcela').serialize()+'&FilaTrabId='+$('#FilaTrabId').val();
    tbContribuinteRes.ajax.url(url).load();

    var tbParcela = $('#tbParcela').DataTable();
    var url = "{{ route('execfila.getdataParcela') }}"+"/?"+$('#formFiltroParcela').serialize()+'&FilaTrabId='+$('#FilaTrabId').val();
    tbParcela.ajax.url(url).load();
    // Get the column API object
    var column = tbParcela.column( 0 );
    // Toggle the visibility
    column.visible(true );
}
function filtrarValidacao() {
    $("#divResultValidacaoRes").show();
    $("#divResultContribuinteRes").hide();
    $("#divResultIM").hide();
    $("#divResultParcela").hide();
    var tbValidacaoRes = $('#tbValidacaoRes').DataTable();
    var url = "{{ route('execfila.getDadosValidarAll') }}"+"/?group=Pes&"+$('#formFiltroParcela').serialize()+'&FilaTrabId='+$('#FilaTrabId').val()+'&Canal='+$('#CanalId').val();
    tbValidacaoRes.ajax.url(url).load();

}
function filtrarTratamento() {
    $("#divResultCanalExec").show();
    $("#divResultParcela").show();

    var tbCanalExec = $('#tbCanalExec').DataTable();
    var url = "{{ route('execfila.getDadosTratRetorno') }}" + "/?group=Pes&" + $('#formFiltroParcela').serialize() + '&FilaTrabId=' + $('#FilaTrabId').val()+'&Canal='+$('#CanalId').val();
    tbCanalExec.ajax.url(url).load();

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
        url: "{!! url('admin/execfila/getDadosFila') !!}",
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
            if(fila==12){
                $("#divResultValidacaoRes").hide();
                $("#divResultCanalExec").show();
            }
            if(fila==11){
                $("#divResultValidacaoRes").show();
                $("#divResultCanalExec").hide();
            }
        }else{
            $('#divResultValidacaoRes').hide();
            $("#divResultCanalExec").hide();
        }

        if(result.filtro_validacao==1){
            $('#divFiltroValidacao').show();
        }else{
            $('#divFiltroValidacao').hide();
        }

        if(result.filtro_eventos==1){
            $('#divFiltroEventos').show();
        }else{
            $('#divFiltroEventos').hide();
        }

        if(result.filtro_tratamento==1){
            $('#divFiltroTratRet').show();
        }else{
            $('#divFiltroTratRet').hide();
        }

        if(result.filtro_notificacao==1){
            $('#divFiltroNotificacao').show();
        }else{
            $('#divFiltroNotificacao').hide();
        }

        if(result.filtro_canal==1){
            $('#divFiltroCanal').show();
        }else{
            $('#divFiltroCanal').hide();
        }
        $('#divBotaoFiltrarVal').hide();
        $('#divBotaoFiltrar').show();
        $('#divBotaoFiltrarTrat').hide();
        if(fila==11){
            $('#divBotaoFiltrarVal').show();
            $('#divBotaoFiltrar').hide();
            $('#divBotaoFiltrarTrat').hide();
            $("#execFila").hide();
            $("#execValida").show();
            $("#execTratamento").hide();
        }
        if(fila==12){
            $('#divBotaoFiltrarVal').hide();
            $('#divBotaoFiltrar').hide();
            $('#divBotaoFiltrarTrat').show();
            $("#execFila").hide();
            $("#execValida").hide();
            $("#execTratamento").show();
        }


    }
});
    filtrarCarteira(fila);
    filtrarRoteiro(fila);
    filtrarValidacoes(fila);
    filtrarEventos(fila);
    filtrarTratRet(fila);
}
function selectCanal(canal) {
    var tbValidacao = $('#tbValidacao').DataTable( );
    var url = "{{ route('execfila.getDadosDataTableValidacoes') }}"+"/?canal="+canal;
    tbValidacao.ajax.url(url).load();

    var tbEventos = $('#tbEventos').DataTable( );
    var url = "{{ route('execfila.getDadosEventos') }}"+"/?canal="+canal;
    tbEventos.ajax.url(url).load();

    var tbTratRet = $('#tbTratRet').DataTable( );
    var url = "{{ route('execfila.getDadosTratRet') }}"+"/?canal="+canal;
    tbTratRet.ajax.url(url).load();

    var table = $('#tbValidacaoRes').DataTable();
    table.clear().draw();
    var table = $('#tbCanalExec').DataTable();
    table.clear().draw();
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
function filtrarEventos(fila){
    var tbEventos = $('#tbEventos').DataTable( );
    var url = "{{ route('execfila.getDadosEventos') }}"+"/?fila="+fila;
    tbEventos.ajax.url(url).load();
}
function filtrarTratRet(fila){
    var tbTratRet = $('#tbTratRet').DataTable( );
    var url = "{{ route('execfila.getDadosTratRet') }}"+"/?fila="+fila;
    tbTratRet.ajax.url(url).load();
}
$(document).ready(function() {
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
    $('input:radio[name="tipoexec"]').change(
        function () {
            if (this.checked && this.value == 'v') {
                $("#divBotaoFiltrar").hide();
                $("#divBotaoFiltrarVal").show();
                $("#divBotaoFiltrarTrat").hide();

                $("#divResultValidacaoRes").show();
                $("#divResultCanalExec").hide();
                $("#divResultContribuinteRes").hide();
                $("#divResultIM").hide();
                $("#divResultParcela").hide();
                $("#execFila").hide();
                $("#execValida").show();
                $("#execTratamento").hide();

            }
            if (this.checked && this.value == 'f') {
                $("#divBotaoFiltrarVal").hide();
                $("#divBotaoFiltrar").show();
                $("#divBotaoFiltrarTrat").hide();

                $("#divResultValidacaoRes").hide();
                $("#divResultCanalExec").hide();
                $("#divResultContribuinteRes").show();
                $("#divResultIM").hide();
                $("#divResultParcela").show();

                $("#execFila").show();
                $("#execValida").hide();
                $("#execTratamento").hide();
            }
            if (this.checked && this.value == 't') {
                $("#divBotaoFiltrarVal").hide();
                $("#divBotaoFiltrar").hide();
                $("#divBotaoFiltrarTrat").show();

                $("#divResultValidacaoRes").hide();
                $("#divResultCanalExec").show();
                $("#divResultContribuinteRes").hide();
                $("#divResultIM").hide();
                $("#divResultParcela").hide();

                $("#execFila").hide();
                $("#execValida").hide();
                $("#execTratamento").show();
            }
        });

    $('#formEditar').on('submit', function (e) {
        var formData = $('#formEditar').serialize();

        $.ajax({
            dataType: 'json',
            type: 'POST',
            data:formData,
            url: '{{ url('admin/pscanal/') }}'+'/' +$('#formEditar #PsCanalId').val(),
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
});


</script>