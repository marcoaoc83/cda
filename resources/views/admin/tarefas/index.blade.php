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
                    <h3>Tarefas</h3>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Lista de Tarefas</h2>
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
                                    <th>Categoria</th>
                                    <th>Titulo</th>
                                    <th>Status</th>
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
        function verTarefa(id) {
            var texto=$("#tar_desc"+id).val();

            swal(""+texto);
        }
        $(document).ready(function() {
            var table = $('.datatable').DataTable({
                "order": [[ 0, "desc" ]],
                processing: true,
                serverSide: true,
                responsive: true,
                "pageLength": 50,
                ajax: '{{ route('tarefas.getdata') }}',
                columns: [
                    {data: 'tar_id', name: 'tar_id'},
                    {data: 'tar_categoria', name: 'tar_categoria'},
                    {data: 'tar_titulo', name: 'tar_titulo'},
                    {
                        data: 'tar_status',
                        name: 'tar_status',
                        render: function ( data, type, row ) {
                            if(data=="Finalizado")
                                return "<span class=\"label label-default\">Finalizado</span>";
                            if(data=="Aguardando")
                                return "<span class=\"label label-primary\">Aguardando</span>";



                            return "<span class=\"label label-success\">Em Execução</span>";
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json"
                }
            });

        });

    </script>
@endpush