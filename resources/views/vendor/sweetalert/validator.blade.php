@if($errors->any())
    <script>
        swal({
            title: 'Erro!',
            html: '{!! implode('<br>',$errors->all()) !!}',
            type: 'error'
        })
    </script>
@endif