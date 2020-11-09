@extends('layouts.app')

@section('styles')
    <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.dataTables.min.css" rel="stylesheet">
@endsection
@section('content')


    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Help</h3>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Listagem de Help</h2>
                            <a href="{{route('help.create')}}" style="margin-left: 15px" type="button" class="btn btn-success btn-sm ">
                                <span class="glyphicon glyphicon-plus-sign "  style="color:white" aria-hidden="true"></span>
                                Adicionar
                            </a>

                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <table class="table table-hover table-bordered table-striped datatable display responsive nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Titulo</th>
                                        <th style="width: 55px">Ação</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /page content -->

@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
    @include('vendor.sweetalert.cdn')
    @include('vendor.sweetalert.view')
    @include('vendor.sweetalert.validator')
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('.datatable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '{{ route('help.getdata') }}',
                columns: [
                    {data: 'help_id', name: 'help_id'},
                    {data: 'help_titulo', name: 'help_titulo'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json"
                }
            });
        });

        function deleteHelp(dataId) {
            swal({
                title             : "Tem certeza?",
                text              : "Este registro será deletado!",
                type              : "warning",
                showCancelButton  : true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText : "Sim",
                cancelButtonText  : "Não"
            }).then((resultado) => {
                if (resultado.value) {
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        _method: 'DELETE',
                        _token: '{!! csrf_token() !!}',
                    },
                    url: '{{ url('admin/help') }}' + '/' + dataId,
                    success: function( msg ) {
                        $('.datatable').DataTable().ajax.reload();
                        swal({
                            position: 'top-end',
                            type: 'success',
                            title: 'Deletado com sucesso!',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    },
                    error: function( data ) {
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
    };
    </script>
@endpush