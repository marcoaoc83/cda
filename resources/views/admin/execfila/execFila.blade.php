<script type="text/javascript">

    $(document).ready(function() {
        $('#execFila').on('click', function(e){
            if($("#FilaTrabId").val()>0) {
                if(rows_selected.length !== 0) {
                    $('#filaId').val($('#FilaTrabId').val());
                    $('#parcelas').val(rows_selected);
                    $('#formParcelas').submit();
                }else {
                    swal({
                        position: 'top-end',
                        type: 'error',
                        title: 'Selecione pelo menos uma parcela!',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            }else{
                swal({
                    position: 'top-end',
                    type: 'error',
                    title: 'Selecione uma Fila no filtro!',
                    showConfirmButton: false,
                    timer: 1500
                })
            }
        });
    }); // document ready


</script>