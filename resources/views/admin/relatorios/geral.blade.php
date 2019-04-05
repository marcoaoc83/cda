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


function filtrar() {
    //$fila=$('#FilaTrabId').val();
    filtrarParcelas();
}

function filtrarParcelas(){

    var tbContribuinteRes = $('#tbContribuinteRes').DataTable();
    var url = "{{ route('execfila.getdataParcela') }}"+"/?group=Pes&"+$('#formFiltroParcela').serialize()+'&FilaTrabId='+$('#FilaTrabId').val();
    tbContribuinteRes.ajax.url(url).load();

    var tbIMRes = $('#tbIMRes').DataTable();
    var url = "{{ route('execfila.getdataParcela') }}"+"/?group=IM&"+$('#formFiltroParcela').serialize()+'&FilaTrabId='+$('#FilaTrabId').val();
    tbIMRes.ajax.url(url).load();

    var tbParcela = $('#tbParcela').DataTable();
    var url = "{{ route('execfila.getdataParcela') }}"+"/?"+$('#formFiltroParcela').serialize()+'&FilaTrabId='+$('#FilaTrabId').val();
    tbParcela.ajax.url(url).load();
    // Get the column API object
    var column = tbParcela.column( 0 );
    // Toggle the visibility
    column.visible(true );
}

function selectFila(fila) {
    $('#divFiltros').show();
    $.ajax({
        type: 'GET',
        dataType: 'json',
        data: {
            _token: '{!! csrf_token() !!}',
            id: fila
        },
        url: "{!! url('admin/relatorios/info') !!}",
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
                $('#divResultIM').show();
            }else{
                $('#divResultIM').hide();
            }
            if(result.resultado_parcelas==1){
                $('#divResultParcela').show();
            }else{
                $('#divResultParcela').hide();
            }
        }
    });

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

});


</script>