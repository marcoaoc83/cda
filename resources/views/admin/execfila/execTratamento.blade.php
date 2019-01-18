<script type="text/javascript">

    $(document).ready(function() {

        $('#execTratamento').on('click', function(e){
            var table = $('#tbCanalExec').DataTable();
            var data = table.rows().data().toArray();
            var csv =  $('#gCSV').is(':checked');
            var txt =  $('#gTXT').is(':checked');
            var gravar =  $('#gravar').is(':checked');
            if(data.length>0) {
                $.ajax({
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        _token: '{!! csrf_token() !!}',
                        PsTratRetId: $('.PsTratRetId').serialize(),
                        dados: JSON.stringify(data),
                        csv:csv,
                        gravar:gravar,
                        txt:txt
                    },
                    url: '{{ route('execfila.tratar') }}',
                    success: function (retorno) {
                        swal({
                            position: 'top-end',
                            type: 'success',
                            title: 'Execução de Tratamento enviada para lista de tarefas!',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        window.location = "{{route('execfila.index')}}";
                    },
                    error: function (retorno) {
                        swal({
                            position: 'top-end',
                            type: 'error',
                            title: 'Error'+retorno,
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                });
            }else{
                swal({
                    position: 'top-end',
                    type: 'error',
                    title: 'Nenhum dado para validar!',
                    showConfirmButton: false,
                    timer: 1500
                })
            }
        });

    }); // document ready


</script>