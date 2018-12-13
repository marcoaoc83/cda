<script type="text/javascript">
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
    var url = "{{ route('execfila.getDadosValidar') }}"+"/?group=Pes&"+$('#formFiltroParcela').serialize()+'&FilaTrabId='+$('#FilaTrabId').val();
    tbValidacaoRes.ajax.url(url).load();

}
function filtrarTratamento() {
    $("#divResultCanalExec").show();
    $("#divResultParcela").show();

    var tbCanalExec = $('#tbCanalExec').DataTable();
    var url = "{{ route('execfila.getDadosTratRetorno') }}" + "/?group=Pes&" + $('#formFiltroParcela').serialize() + '&FilaTrabId=' + $('#FilaTrabId').val();
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
            $('#divResultValidacaoRes').show();
            $('#tipoexecV').parent( "label" ).show();
        }else{
            $('#divResultValidacaoRes').hide();
            $('#tipoexecV').parent( "label" ).hide();
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
});
</script>