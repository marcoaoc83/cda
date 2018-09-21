@extends('portal.index.index')
@section('content')
    <div class="pf-main">
        <div class="container pt-4 pb-4 pl-4 pr-4">
            <div class="h1 pf-text-secondary font-weight-light mb-3 pf-text-titulo">Seus Débitos</div>
            <p class="pf-text-muted mb-4">Selecione a inscrição para consultar débitos em aberto!</p>
            <div class="row justify-content-between pt-lg-4 pb-lg-4">
                <div class="card-body">
                    <table id="tbTributo" class="table table-hover table-bordered table-striped datatable display responsive nowrap" style="width:100%; font-size: 12px">
                        <thead>
                            <tr>
                                <th>Tipo de Tributo</th>
                                <th>Inscrição Municipal</th>
                                <th>Endereço</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
<!-- /page content -->
@endsection

@push('scripts')
    @include('vendor.sweetalert.cdn')
    @include('vendor.sweetalert.view')
    @include('vendor.sweetalert.validator')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.js"></script>

    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.2.7/js/dataTables.select.min.js"></script>


    <script>
        $(document).ready(function() {
            var tbTributo = $('#tbTributo').DataTable({
                processing: true,
                responsive: true,
                searching: true,
                info: false,
                paging: false,
                "lengthChange": false,
                select: {
                    style: 'single',
                    info: false

                },
                initComplete: function () {
                    $('.dataTables_filter').css({ 'float': 'right'});
                },
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json"
                },
                ajax: {
                    "url": "{{ route('portal.getDataTributo') }}",
                    "data": {
                        "PESSOAID": '1'
                    }
                },
                columns: [
                    {
                        data: 'Tributo',
                        name: 'Tributo'
                    },
                    {
                        data: 'INSCRICAO',
                        name: 'INSCRICAO'
                    },
                    {
                        data: 'Endereco',
                        name: 'Endereco'
                    }
                ],
            });


        });
    </script>
@endpush